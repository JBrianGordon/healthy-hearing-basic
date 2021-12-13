<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QueueTaskLog $queueTaskLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Queue Task Log'), ['action' => 'edit', $queueTaskLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Queue Task Log'), ['action' => 'delete', $queueTaskLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queueTaskLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Queue Task Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Queue Task Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="queueTaskLogs view content">
            <h3><?= h($queueTaskLog->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($queueTaskLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $queueTaskLog->has('user') ? $this->Html->link($queueTaskLog->user->id, ['controller' => 'Users', 'action' => 'view', $queueTaskLog->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Reschedule') ?></th>
                    <td><?= h($queueTaskLog->reschedule) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= $this->Number->format($queueTaskLog->start_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= $this->Number->format($queueTaskLog->end_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpu Limit') ?></th>
                    <td><?= $this->Number->format($queueTaskLog->cpu_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= $this->Number->format($queueTaskLog->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($queueTaskLog->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= $this->Number->format($queueTaskLog->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($queueTaskLog->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($queueTaskLog->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Executed') ?></th>
                    <td><?= h($queueTaskLog->executed) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scheduled') ?></th>
                    <td><?= h($queueTaskLog->scheduled) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scheduled End') ?></th>
                    <td><?= h($queueTaskLog->scheduled_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Restricted') ?></th>
                    <td><?= $queueTaskLog->is_restricted ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Command') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($queueTaskLog->command)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Result') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($queueTaskLog->result)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
