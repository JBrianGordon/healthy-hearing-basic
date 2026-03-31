<?php $this->Vite->script('admin_common','admin'); ?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Queued Jobs Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link('Queued Jobs', ['action' => 'queuedJobs'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link('Archived', ['action' => 'queuedJobs', '?' => ['archived' => true]], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link('Run All', ['action' => 'runQueuedJobs'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Queued Jobs - <?= $archived ? 'Archived' : 'Pending' ?></h2>
                <div class="queuedJobs index content">
                    <?= $this->element('pagination') ?>
                    <div class="table-responsive mt30">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('id') ?></th>
                                    <th><?= $this->Paginator->sort('job_task') ?></th>
                                    <th><?= $this->Paginator->sort('data') ?></th>
                                    <th>
                                        <?= $this->Paginator->sort('completed') ?><br>
                                        <?= $this->Paginator->sort('progress') ?>
                                    </th>
                                    <th><?= $this->Paginator->sort('failed', 'Errors') ?></th>
                                    <th><?= $this->Paginator->sort('status') ?></th>
                                    <th><?= $this->Paginator->sort('priority') ?></th>
                                    <th><?= $this->Paginator->sort('created') ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($queuedJobs as $queuedJob): ?>
                                    <tr>
                                        <td><?= $queuedJob->id ?></td>
                                        <td><?= $queuedJob->job_task ?></td>
                                        <td style="max-width:200px; overflow:scroll;" nowrap><?= $queuedJob->data ?></td>
                                        <td>
                                            <?= $queuedJob->completed ?><br>
                                            <?= $queuedJob->progress ?>
                                        </td>
                                        <td style="max-width:200px; overflow:scroll;">
                                            <?php if (!empty($queuedJob->failed)): ?>
                                                <span class='badge bg-danger'>Failed</span>
                                            <?php endif; ?>
                                            <?php if (!empty($queuedJob->failure_message)): ?>
                                                <br><br>Failure message: <?= $queuedJob->failure_message ?>
                                            <?php else: ?>
                                                <?php if (!empty($queuedJob->fetched) && empty($queuedJob->progress)): ?>
                                                    <br><br>Warning: Job has been started but no progress reported. Potentially an uncaught memory exception.
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $queuedJob->status ?></td>
                                        <td><?= $queuedJob->priority ?></td>
                                        <td>
                                            <?= $this->Time->nice($queuedJob->created) ?>
                                            <?php if (!empty($queuedJob->fetched)): ?>
                                                <br><br>Fetched:  <?= $this->Time->nice($queuedJob->fetched) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-vertical">
                                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> View',
                                                    ['action' => 'viewQueuedJob', $queuedJob->id],
                                                    ['class' => 'btn btn-xs btn-default', 'escape' => false]); ?>
                                                <?php if (!$archived): ?>
                                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> Delete',
                                                        ['action' => 'deleteQueuedJob', $queuedJob->id],
                                                        ['class' => 'btn btn-xs btn-danger', 'escape' => false,
                                                        'confirm' => __('Are you sure you want to delete # {0}?', $queuedJob->id)]); ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $this->element('pagination') ?>
                </div>
            </div>
        </div>
    </section>
</div>
