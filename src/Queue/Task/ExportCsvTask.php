<?php

namespace App\Queue\Task;

use Queue\Queue\Task;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\View\ViewBuilder;
use Cake\Mailer\Mailer;
use Cake\Core\Configure;

class ExportCsvTask extends Task {

    /**
     * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void {
        $exportData = $this
            ->getTableLocator()
            ->get($data['vars']['table'])
            ->find('search', [
                'search' => $data['vars']['queryParams'],
            ])
            ->contain($data['vars']['containedTables']);

        if ($exportData->count() > 150000) {
            // Large exports will run into an uncaught memory exception and shutdown.
            // Handle these more gracefully. This will email the user and let them know the export is too big.
            $filesize = 6000000;
        } else {
            $builder = new ViewBuilder();
            $builder
                ->setLayout(null)
                ->setClassName('CsvView.Csv')
                ->setOptions([
                    'serialize' => 'exportData',
                    'header' => $data['vars']['header'],
                    'extract' => $data['vars']['extract'],
                ]);
            $view = $builder->setVars($exportData->toArray())->build();
            $view->set(compact('exportData'));

            // Save the file
            file_put_contents($data['vars']['csvExportFile'], $view->render());
            $filesize = filesize($data['vars']['csvExportFile']);
        }

        $this->Mailer = new Mailer('default');
        $to = $data['vars']['to'] ?? Configure::read('itEmails');
        if (!empty($data['vars']['subject'])) {
            $subject = $data['vars']['subject'];
        } elseif (!empty($data['vars']['table'])) {
            $subject = $data['vars']['table'].' export : '.date('Y-m-d');
        } else {
            $subject = 'Data export : '.date('Y-m-d');
        }
        if (Configure::read('env') != 'prod') {
            $subject = '('.Configure::read('env').') '.$subject;
        }
        $this->Mailer
            ->setEmailFormat('html')
            ->setTo($to)
            ->setSubject($subject)
            ->viewBuilder()
                ->setTemplate('Export/export')
                ->setVar('table', $data['vars']['table'])
                ->setVar('filesize', $filesize)
                ->setVar('username', $data['vars']['username']);

        if (!empty($data['vars']['csvExportFile'])) {
            // Do not attach files larger than 5MB
            // TODO: Can we zip these?
            if ($filesize <= 5000000) {
                $this->Mailer->setAttachments([
                    $data['vars']['csvExportFile']
                ]);
            }
        }
        $this->Mailer->deliver();
    }

}
