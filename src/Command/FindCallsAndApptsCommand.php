<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\CaCallGroup;
use App\Model\Entity\CsCall;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

/**
 * Report calls and appts for a list of clinics.
 */
class FindCallsAndApptsCommand extends Command
{
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
        $parser
            ->setDescription('Generate a report of calls and appts for a list of clinics')
            ->addOption('to', [
                'short' => 't',
                'help' => 'to: email address'
            ])
            ->addOption('username', [
                'short' => 'u',
                'help' => 'username'
            ])
            ->addOption('start', [
                'short' => 's',
                'help' => 'Start date for report'
            ])
            ->addOption('end', [
                'short' => 'e',
                'help' => 'End date for report'
            ]);

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
        $to = $args->getOption('to') ?? Configure::read('adminEmails');
        $username = $args->getOption('username') ?? '';
        $startDate = $args->getOption('start') ?? null;
        $endDate = $args->getOption('end') ?? null;
        $this->CaCallGroups = $this->fetchTable('CaCallGroups');
        $this->CsCalls = $this->fetchTable('CsCalls');

        if (empty($startDate) || empty($endDate)) {
            $io->out("Must specify a start and end date.");
            return false;
        }
        // Convert to timestamps
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $fileName = 'clinicCallsAppts_'.date('mdY', $startDate).'_'.date('mdY', $endDate).'.csv';
        $filePath = WWW_ROOT . 'csvs' . DS . $fileName;
        $startTime = date('Y-m-d 00:00:00', $startDate);
        $endTime = date('Y-m-d 23:59:59', $endDate);
        $startDate = date('M-j-y', $startDate);
        $endDate = date('M-j-y', $endDate);
        $clinicListFilename = WWW_ROOT . 'csvs' . DS . 'uploadClinicsForCallsAppts.csv';
        if (($file = fopen($clinicListFilename, "r")) !== false) {
            // get keys from the first row
            $keys = fgetcsv($file);
            while (($line = fgetcsv($file)) !== false) {
                $locationList[] = array_combine($keys, $line);
            }
            fclose($file);
        }
        $locationCount = count($locationList);

        $io->helper('BaseShell')->title("Report total calls and appointments for a group of $locationCount clinics: $startDate to $endDate");

        $file_data = "id,title,start date,end date,call groups,usable calls,prospects,appts set,call tracking calls,ct usable calls,ct prospects\n";

        $progress = $io->helper('Progress');
        $progress->init([
            'total' => $locationCount,
        ]);
        foreach ($locationList as $location) {
            $locationId = $location['id'];
            $locationTitle = $location['title'];
            //If id column is longer than 10 (length of our id numbers), move everything after 10th character to the title column
            if(strlen($locationId) > 10){
                $locationTitle = substr($locationId, 10);
                $locationId = substr($locationId, 0, 10);
            }

            //Strip out commas and all following text (typically ", LLC" or ", Inc.")
            if (strpos($locationTitle, ",") != false) {
                $locationTitle = substr($locationTitle, 0, strpos($locationTitle, ","));
            }
            // call groups
            $callGroups = $this->CaCallGroups->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'AND' => [
                        'created >=' => $startTime,
                        'created <=' => $endTime,
                    ]
                ]
            ])->count();
            // usable calls
            $usableCalls = $this->CaCallGroups->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'prospect IN' => [CaCallGroup::PROSPECT_YES, CaCallGroup::PROSPECT_NO],
                    'AND' => [
                        'created >=' => $startTime,
                        'created <=' => $endTime,
                    ]
                ]
            ])->count();
            // prospects
            $prospects = $this->CaCallGroups->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'prospect' => CaCallGroup::PROSPECT_YES,
                    'AND' => [
                        'created >=' => $startTime,
                        'created <=' => $endTime,
                    ]
                ]
            ])->count();
            // appts set
            $apptsSet = $this->CaCallGroups->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'score IN' => [CaCallGroup::SCORE_APPT_SET, CaCallGroup::SCORE_APPT_SET_DIRECT],
                    'AND' => [
                        'created >=' => $startTime,
                        'created <=' => $endTime,
                    ]
                ]
            ])->count();
            // Call Tracking calls
            $ctCalls = $this->CsCalls->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'AND' => [
                        'start_time >=' => $startTime,
                        'start_time <=' => $endTime,
                    ]
                ]
            ])->count();
            // CT usable calls
            $ctUsableCalls = $this->CsCalls->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'prospect IN' => [CsCall::PROSPECT_YES, CsCall::PROSPECT_NO],
                    'AND' => [
                        'start_time >=' => $startTime,
                        'start_time <=' => $endTime,
                    ]
                ]
            ])->count();
            // CT prospects
            $ctProspects = $this->CsCalls->find('all', [
                'contain' => [],
                'conditions' => [
                    'location_id' => $locationId,
                    'prospect' => CsCall::PROSPECT_YES,
                    'AND' => [
                        'start_time >=' => $startTime,
                        'start_time <=' => $endTime,
                    ]
                ]
            ])->count();

            // Add the data for this location
            $file_data .= "\"{$locationId}\",";
            $file_data .= "\"{$locationTitle}\",";
            $file_data .= "\"{$startDate}\",";
            $file_data .= "\"{$endDate}\",";
            $file_data .= "\"{$callGroups}\",";
            $file_data .= "\"{$usableCalls}\",";
            $file_data .= "\"{$prospects}\",";
            $file_data .= "\"{$apptsSet}\",";
            $file_data .= "\"{$ctCalls}\",";
            $file_data .= "\"{$ctUsableCalls}\",";
            $file_data .= "\"{$ctProspects}\"\n";
            $progress->increment(1);
            $progress->draw();
        }
        $io->helper('BaseShell')->writeFile($file_data, $filePath, true);
        $filesize = filesize($filePath);
        $subject = "Total calls and appts for a group of clinics ({$startDate} to {$endDate})";
        if (Configure::read('env') != 'prod') {
            $subject = '('.Configure::read('env').') '.$subject;
        }
        $body = "Found total call groups and appointments set for $locationCount clinics.<br>Date range: $startDate to $endDate.";
        // Send email
        $this->Mailer = new Mailer('default');
        $this->Mailer
            ->setEmailFormat('html')
            ->setTo($to)
            ->setSubject($subject)
            ->viewBuilder()
                ->setTemplate('admin')
                ->setVar('username', $username)
                ->setVar('content', $body)
                ->setVar('filesize', $filesize);

        if (!empty($filesize)) {
            // Do not attach files larger than 5MB
            if ($filesize <= 5000000) {
                $this->Mailer->setAttachments([
                    $filePath
                ]);
            }
        }
        $this->Mailer->deliver();
        $io->out('Report emailed to: ' . $to);
        $io->out();
    }
}
