<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\CaCallGroup;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

/**
 * Report calls by state command.
 */
class CallReportByStateCommand extends Command
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
            ->setDescription('Generate a report calls by state for a date range')
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

        if (empty($startDate) || empty($endDate)) {
            $io->out("Must specify a start and end date.");
            return false;
        }
        // Convert to timestamps
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $fileName = 'callReportByState_'.date('mdY', $startDate).'_'.date('mdY', $endDate).'.csv';
        $filePath = WWW_ROOT . 'csvs' . DS . $fileName;
        $startTime = date('Y-m-d 00:00:00', $startDate);
        $endTime = date('Y-m-d 23:59:59', $endDate);
        $startDate = date('M d', $startDate);
        $endDate = date('M d', $endDate);

        $io->helper('BaseShell')->title("Report call data by state: $startDate to $endDate");

        $file_data = "\"State\",\"# Prospect calls ({$startDate}-{$endDate})\",\"# Appts ({$startDate}-{$endDate})\",\"Avg wait time in days ({$startDate}-{$endDate})\"\n";

        $states = Configure::read('states');
        $progress = $io->helper('Progress');
        $progress->init([
            'total' => count($states),
        ]);
        foreach ($states as $abbr => $state) {
            $prospects = $this->CaCallGroups->find('all', [
                'contain' => ['Locations'],
                'conditions' => [
                    'Locations.state' => $abbr,
                    'CaCallGroups.prospect' => CaCallGroup::PROSPECT_YES,
                    'AND' => [
                        'CaCallGroups.created >=' => $startTime,
                        'CaCallGroups.created <=' => $endTime,
                    ]
                ]
            ])->count();
            $appts = $this->CaCallGroups->find('all', [
                'contain' => 'Locations',
                'conditions' => [
                    'Locations.state' => $abbr,
                    'CaCallGroups.score IN' => [CaCallGroup::SCORE_APPT_SET, CaCallGroup::SCORE_APPT_SET_DIRECT],
                    'AND' => [
                        'CaCallGroups.created >=' => $startTime,
                        'CaCallGroups.created <=' => $endTime,
                    ]
                ]
            ])->all();
            $totalWaitTime = 0;
            foreach ($appts as $appt) {
                // Find the difference between appt date and call created date
                $totalWaitTime += $appt->appt_date->diffInDays($appt->created);
            }
            $apptsCount = count($appts);
            $avgWaitTime = '';
            if ($apptsCount > 0) {
                $avgWaitTime = round(($totalWaitTime / $apptsCount), 0);
            }

            // Add the data for this state
            $file_data .= "\"{$abbr}\","; // State
            $file_data .= "\"{$prospects}\","; // # Prospect calls
            $file_data .= "\"{$apptsCount}\","; // # Appts
            $file_data .= "\"{$avgWaitTime}\"\n"; // Avg wait time
            $progress->increment(1);
            $progress->draw();
        }
        $io->helper('BaseShell')->writeFile($file_data, $filePath, true);
        $filesize = filesize($filePath);
        $subject = "Call report by state ({$startDate} to {$endDate})";
        if (Configure::read('env') != 'prod') {
            $subject = '('.Configure::read('env').') '.$subject;
        }
        $body = "Report of call data by state.<br>Date range: {$startDate} to {$endDate}.";
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
