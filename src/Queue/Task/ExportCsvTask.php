<?php

namespace App\Queue\Task;

use Queue\Queue\Task;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\View\ViewBuilder;
use Cake\Mailer\Mailer;

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

        $builder = new ViewBuilder();
        $builder
            ->setLayout(null)
            ->setClassName('CsvView.Csv')
            ->setOptions([
                'serialize' => 'exportData',
                'header' => $data['vars']['header'],
                'extract' => $data['vars']['extract'],
            ]);

        $view = $builder->build($exportData->toArray());
        $view->set(compact('exportData'));

        // Save the file
        file_put_contents($data['vars']['csvExportFile'], $view->render());

        $this->Mailer = new Mailer('default');
        $this->Mailer
            ->setEmailFormat('html')
            ->viewBuilder()
            ->setTemplate('Export/reviews');

        if (!empty($data['vars']['csvExportFile'])) {
            $this->Mailer->setAttachments([
                $data['vars']['csvExportFile']
            ]);
        }

        $this->Mailer->deliver();
    }

}