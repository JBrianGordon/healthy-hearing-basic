<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use App\Model\Entity\CsCall;

class CallsImportLeadscoreReportCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'calls importLeadscoreReport';
    }

    protected $defaultTable = 'CsCalls';

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        $parser->setDescription('Import LeadScore reports from CallSource');

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->Locations = $this->fetchTable('Locations');

        $io->out('Import LeadScore reports from CallSource');
        $io->hr();

        $totalCallsSaved = 0;
        $totalDuplicates = 0;
        $serverCountry = Configure::read('country');

        //********************************************************************
        // TODO TEMPORARY: COPY FILES FROM HHAPP4.
        // Eventually we will move this from hhapp4 to our Cake4 ftp container
        //********************************************************************
        $hh4Path = "root@hhapp4:/var/ftp/callSource/leadscore/archive/";
        $filename =  "HealthyHearing_CallDetailswithLeadScoreEnhLS_".date('Ymd').".csv";
        $localPath = "ftp/callSource/leadscore/";
        $io->out("Copying from". $hh4Path.$filename." to ".$localPath.$filename);
        $cmd = "scp ".$hh4Path.$filename." ".$localPath.".";
        shell_exec($cmd);
        if (!file_exists($localPath.$filename)) {
            // File didn't exist in archive. Try main leadscore folder.
            $hh4Path = "root@hhapp4:/var/ftp/callSource/leadscore/";
            $cmd = "scp ".$hh4Path.$filename." ".$localPath.".";
            shell_exec($cmd);
        }
        if (!file_exists($localPath.$filename)) {
            $io->error("Error: Failed to find leadscore file on hhapp4");
            return static::CODE_ERROR;
        }

        $reportFiles = scandir($localPath);
        // Remove '.' and '..' from the results
        $reportFiles = array_diff($reportFiles, array('.', '..', 'archive'));

        foreach ($reportFiles as $filename) {
            $io->info('Reading file '.$localPath.$filename);
            $fileData = csvToArrayWithHeaders($localPath.$filename);
            if (empty($fileData)) {
                $io->error("No data found in $filename");
                continue;
            }
            $fileCallsSaved = 0;
            $fileDuplicates = 0;
            $fileConcierge = 0;
            $fileBlankCode = 0;
            $usCount = 0;
            $caCount = 0;
            // Parse file
            $fields = [
                'Call ID' => 'id_callsource_call',
                'Location Code' => 'location_id',
                'Location Name' => 'location_name',
                'Date' => 'date',
                'Time' => 'time',
                'Result' => 'result',
                'Duration' => 'duration',
                'Call Type' => 'call_type',
                'Call Status' => 'call_status',
                'LeadScore' => 'leadscore',
                'Call Recording' => 'recording_url',
                'DID' => 'tracking_number',
                'ANI' => 'caller_phone',
                'Target' => 'clinic_phone',
                'Ad Source1' => 'ad_source',
                'Caller First Name' => 'caller_firstname',
                'Last Name' => 'caller_lastname'
            ];

            foreach ($fileData as $callData) {
                foreach ($fields as $column => $field) {
                    if (!isset($callData[$column])) {
                        $io->error("Column $column does not exist in file.");
                        continue;
                    }
                    $data[$field] = $callData[$column];
                }
                if ($data['ad_source'] == 'hearingdirectory.ca') {
                    $callCountry = 'CA';
                    $caCount++;
                } else {
                    $callCountry = 'US';
                    $usCount++;
                }
                if (empty($data['location_id'])) {
                    // The "Location Code" field should always have data. Display a warning so we can let CallSource know.
                    // In the meantime, try to pull location_id from "Location Name" field.
                    $io->out("Warning: Call ".$data['id_callsource_call']." for location ".$data['location_name']." has a blank Location Code.");
                    $fileBlankCode++;
                    if (preg_match('/[0-9]{4,}/', $data['location_name'], $matches) == 1) {
                        $data['location_id'] = $matches[0];
                    }
                }
                $data['location_id'] = str_replace('HDCA-', '', $data['location_id']);
                $location = $this->Locations->find('all', [
                    'conditions' => [
                        'id' => $data['location_id']
                    ]
                ])->first();
                // File includes both US and Canadian calls. Filter out calls for a different country.
                if (!empty($location) && ($serverCountry == $callCountry)) {
                    // Filter out call assist calls
                    if (!$location->is_call_assist) {
                        $data['start_time'] = date('Y-m-d H:i:s', strtotime($data['date'].' '.$data['time']));
                        if (empty($data['call_type'])) {
                            $data['prospect'] = CsCall::PROSPECT_UNKNOWN;
                        } else if ($data['call_type'] == 'Prospect') {
                            $data['prospect'] = CsCall::PROSPECT_YES;
                        } else {
                            $data['prospect'] = CsCall::PROSPECT_NO;
                        }
                        // Make sure we don't add any duplicates
                        $csCall = $this->CsCalls->find('all', [
                            'conditions' => [
                                'id_callsource_call' => $data['id_callsource_call']
                            ]
                        ])->first();
                        if (!empty($csCall)) {
                            $io->out("Warning: found a duplicate for id_callsource_call ".$data['id_callsource_call']);
                            $fileDuplicates++;
                            $totalDuplicates++;
                        } else {
                            $csCall = $this->CsCalls->newEmptyEntity();
                            $fileCallsSaved++;
                            $totalCallsSaved++;
                        }
                        unset($data['location_name']);
                        $this->CsCalls->patchEntity($csCall, $data);
                        $this->CsCalls->save($csCall);
                    } else {
                        $fileConcierge++;
                        $io->out("Warning: found a call for location ".$location->id." which should be concierge.");
                    }
                }
            }
            $io->out(count($fileData)." calls found in file. (".$usCount." US, ".$caCount." CA)");
            $io->out($fileConcierge." concierge calls found.");
            if (!empty($fileBlankCode)) {
                $io->out($fileBlankCode." calls found with blank Location Code.");
            }
            $io->out($fileDuplicates." duplicates found.");
            $io->out($fileCallsSaved." new calls saved.");

            // Archive the file
            $io->out("Archiving file: $filename");
            $status = rename($localPath.$filename, $localPath.'archive/'.$filename);
            if ($status) {
                $io->out('  success');
            } else {
                $io->out('  fail');
            }
        }
        $io->out($totalDuplicates." total duplicates found.");
        $io->out($totalCallsSaved." total new calls saved. Done.");

        return static::CODE_SUCCESS;
    }
}
