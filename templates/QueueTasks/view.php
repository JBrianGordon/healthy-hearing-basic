<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QueueTask $queueTask
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Queue Task'), ['action' => 'edit', $queueTask->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Queue Task'), ['action' => 'delete', $queueTask->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queueTask->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Queue Tasks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Queue Task'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="queueTasks view content">
            <h3><?= h($queueTask->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($queueTask->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $queueTask->has('user') ? $this->Html->link($queueTask->user->id, ['controller' => 'Users', 'action' => 'view', $queueTask->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Reschedule') ?></th>
                    <td><?= h($queueTask->reschedule) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= $this->Number->format($queueTask->start_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= $this->Number->format($queueTask->end_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpu Limit') ?></th>
                    <td><?= $this->Number->format($queueTask->cpu_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= $this->Number->format($queueTask->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($queueTask->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= $this->Number->format($queueTask->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($queueTask->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($queueTask->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Executed') ?></th>
                    <td><?= h($queueTask->executed) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scheduled') ?></th>
                    <td><?= h($queueTask->scheduled) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scheduled End') ?></th>
                    <td><?= h($queueTask->scheduled_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Restricted') ?></th>
                    <td><?= $queueTask->is_restricted ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Command') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($queueTask->command)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Result') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($queueTask->result)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
