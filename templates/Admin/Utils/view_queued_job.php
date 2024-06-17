<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Queued Jobs Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link('Queued Jobs', ['action' => 'queuedJobs'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link('Archived', ['action' => 'queuedJobs', '?' => ['archived' => true]], ['class' => 'btn btn-default']) ?>
                <?= $this->Form->postLink(' Delete', ['action' => 'delete', $queuedJob->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queuedJob->id), 'class' => 'btn btn-danger bi bi-trash']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">                    
                <h2>View Queued Job</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Id</th>
                            <td><?= $queuedJob->id ?></td>
                        </tr>
                        <tr>
                            <th>Job task</th>
                            <td><?= $queuedJob->job_task ?></td>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <td style="word-break: break-word;"><?= $queuedJob->data ?></td>
                        </tr>
                        <tr>
                            <th>Job group</th>
                            <td><?= $queuedJob->job_group ?></td>
                        </tr>
                        <tr>
                            <th>Reference</th>
                            <td><?= $queuedJob->reference ?></td>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <td><?= $queuedJob->created ?></td>
                        </tr>
                        <tr>
                            <th>Not before</th>
                            <td><?= $queuedJob->notbefore ?></td>
                        </tr>
                        <tr>
                            <th>Fetched</th>
                            <td><?= $queuedJob->fetched ?></td>
                        </tr>
                        <tr>
                            <th>Completed</th>
                            <td><?= $queuedJob->completed ?></td>
                        </tr>
                        <tr>
                            <th>Progress</th>
                            <td><?= $queuedJob->progress ?></td>
                        </tr>
                        <tr>
                            <th>Failed</th>
                            <td><?= $queuedJob->failed ?></td>
                        </tr>
                        <tr>
                            <th>Failure message</th>
                            <td><?= $queuedJob->failure_message ?></td>
                        </tr>
                        <tr>
                            <th>Worker key</th>
                            <td><?= $queuedJob->workerkey ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= $queuedJob->status ?></td>
                        </tr>
                        <tr>
                            <th>Priority</th>
                            <td><?= $queuedJob->priority ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
