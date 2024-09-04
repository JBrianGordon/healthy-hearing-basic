<?php

namespace App\Queue\Task;

use Queue\Queue\Task;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\View\ViewBuilder;
use Cake\Mailer\Mailer;

class ShellTask extends Task {

    /**
     * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void {
        $command = $data['vars']['command'];
        $output = shell_exec('cd /shared/httpd/hh/HH-CakePHP-4x && bin/cake '.$command);
        echo $output;
    }
}
