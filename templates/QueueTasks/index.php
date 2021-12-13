<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QueueTask[]|\Cake\Collection\CollectionInterface $queueTasks
 */
?>
<div class="queueTasks index content">
    <?= $this->Html->link(__('New Queue Task'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Queue Tasks') ?></h3>
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
                <?php foreach ($queueTasks as $queueTask): ?>
                <tr>
                    <td><?= h($queueTask->id) ?></td>
                    <td><?= $queueTask->has('user') ? $this->Html->link($queueTask->user->id, ['controller' => 'Users', 'action' => 'view', $queueTask->user->id]) : '' ?></td>
                    <td><?= h($queueTask->created) ?></td>
                    <td><?= h($queueTask->modified) ?></td>
                    <td><?= h($queueTask->executed) ?></td>
                    <td><?= h($queueTask->scheduled) ?></td>
                    <td><?= h($queueTask->scheduled_end) ?></td>
                    <td><?= h($queueTask->reschedule) ?></td>
                    <td><?= $this->Number->format($queueTask->start_time) ?></td>
                    <td><?= $this->Number->format($queueTask->end_time) ?></td>
                    <td><?= $this->Number->format($queueTask->cpu_limit) ?></td>
                    <td><?= h($queueTask->is_restricted) ?></td>
                    <td><?= $this->Number->format($queueTask->priority) ?></td>
                    <td><?= $this->Number->format($queueTask->status) ?></td>
                    <td><?= $this->Number->format($queueTask->type) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $queueTask->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $queueTask->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $queueTask->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queueTask->id)]) ?>
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
