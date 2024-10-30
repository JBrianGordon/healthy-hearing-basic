<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\Location;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

/**
 * Tier Status Change command.
 */
class TierStatusChangeCommand extends Command
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
            ->setDescription('Generate a report of Oticon import tier changes over time')
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
        $this->Locations = $this->fetchTable('Locations');

        $io->out("Generating Tier Status Change report.");
        $io->out("startDate = {$startDate}");
        $io->out("endDate = {$endDate}");
        $io->out("email = {$to}");

        $filename = 'tier_status_changes.csv';
        $sitePath = $io->helper('BaseShell')->getSiteHost() . DS . 'csvs' . DS . $filename;
        $filePath = WWW_ROOT . 'csvs' . DS . $filename;
        $locations = $this->Locations->find('all', [
            'fields' => ['id','title','city','state','zip','id_oticon','is_active','is_show'],
            'contain' => [],
        ])->all();

        // Get and use the Progress Helper.
        $progress = $io->helper('Progress');
        $progress->init([
            'total' => count($locations),
        ]);
        $file_data = "\"Clinic Title\",\"ID\",\"Oticon ID\",\"Url\",\"Active Now\",\"Show Now\",\"Current Tier\",\"Total Imports\",\"Tier 1\",\"Tier 2\",\"Tier 3\",\"Tier 0\",\"Total Changes\"\n";
        foreach ($locations as $location) {
            $tierStats = $this->Locations->tierChangeStats($location->id, $startDate, $endDate);
            $isActive = empty($location->is_active) ? '0' : '1';
            $isShow = empty($location->is_show) ? '0' : '1';
            $file_data .= "\"{$location->title}\",";
            $file_data .= "\"{$location->id}\",";
            $file_data .= "\"{$location->id_oticon}\",";
            $file_data .= "\"https://www.healthyhearing.com" . Router::url($location->hh_url) ."\",";
            $file_data .= "\"{$isActive}\",";
            $file_data .= "\"{$isShow}\",";
            $file_data .= "\"{$tierStats['current_tier']}\",";
            $file_data .= "\"{$tierStats['total_updates']}\",";
            $file_data .= "\"{$tierStats['tier_1']}\",";
            $file_data .= "\"{$tierStats['tier_2']}\",";
            $file_data .= "\"{$tierStats['tier_3']}\",";
            $file_data .= "\"{$tierStats['tier_0']}\",";
            $file_data .= "\"{$tierStats['times_changed']}\"\n";
            $progress->increment(1);
            $progress->draw();
        }
        $io->helper('BaseShell')->writeFile($file_data, $filePath, true);
        $filesize = filesize($filePath);
        $body = "Tier Status Change Report for dates: ";
        if (empty($startDate) && empty($endDate)) {
            $body .= "all<br>";
        } else {
            $body.= "$startDate to $endDate<br>";
        }
        $subject = 'Tier Status Change Report';
        if (Configure::read('env') != 'prod') {
            $subject = '('.Configure::read('env').') '.$subject;
        }
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
