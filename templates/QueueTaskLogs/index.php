<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QueueTaskLog[]|\Cake\Collection\CollectionInterface $queueTaskLogs
 */
?>
<div class="queueTaskLogs index content">
    <?= $this->Html->link(__('New Queue Task Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Queue Task Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('executed') ?></th>
                    <th><?= $this->Paginator->sort('scheduled') ?></th>
                    <th><?= $this->Paginator->sort('scheduled_end') ?></th>
                    <th><?= $this->Paginator->sort('reschedule') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('end_time') ?></th>
                    <th><?= $this->Paginator->sort('cpu_limit') ?></th>
                    <th><?= $this->Paginator->sort('is_restricted') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($queueTaskLogs as $queueTaskLog): ?>
                <tr>
                    <td><?= h($queueTaskLog->id) ?></td>
                    <td><?= $queueTaskLog->has('user') ? $this->Html->link($queueTaskLog->user->id, ['controller' => 'Users', 'action' => 'view', $queueTaskLog->user->id]) : '' ?></td>
                    <td><?= h($queueTaskLog->created) ?></td>
                    <td><?= h($queueTaskLog->modified) ?></td>
                    <td><?= h($queueTaskLog->executed) ?></td>
                    <td><?= h($queueTaskLog->scheduled) ?></td>
                    <td><?= h($queueTaskLog->scheduled_end) ?></td>
                    <td><?= h($queueTaskLog->reschedule) ?></td>
                    <td><?= $this->Number->format($queueTaskLog->start_time) ?></td>
                    <td><?= $this->Number->format($queueTaskLog->end_time) ?></td>
                    <td><?= $this->Number->format($queueTaskLog->cpu_limit) ?></td>
                    <td><?= h($queueTaskLog->is_restricted) ?></td>
                    <td><?= $this->Number->format($queueTaskLog->priority) ?></td>
                    <td><?= $this->Number->format($queueTaskLog->status) ?></td>
                    <td><?= $this->Number->format($queueTaskLog->type) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $queueTaskLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $queueTaskLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $queueTaskLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queueTaskLog->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
