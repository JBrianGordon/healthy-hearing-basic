<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCall[]|\Cake\Collection\CollectionInterface $caCalls
 */
?>
<div class="caCalls index content">
    <?= $this->Html->link(__('New Ca Call'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Ca Calls') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('ca_call_group_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('duration') ?></th>
                    <th><?= $this->Paginator->sort('call_type') ?></th>
                    <th><?= $this->Paginator->sort('recording_url') ?></th>
                    <th><?= $this->Paginator->sort('recording_duration') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($caCalls as $caCall): ?>
                <tr>
                    <td><?= $this->Number->format($caCall->id) ?></td>
                    <td><?= $caCall->has('ca_call_group') ? $this->Html->link($caCall->ca_call_group->id, ['controller' => 'CaCallGroups', 'action' => 'view', $caCall->ca_call_group->id]) : '' ?></td>
                    <td><?= $caCall->has('user') ? $this->Html->link($caCall->user->id, ['controller' => 'Users', 'action' => 'view', $caCall->user->id]) : '' ?></td>
                    <td><?= h($caCall->start_time) ?></td>
                    <td><?= $this->Number->format($caCall->duration) ?></td>
                    <td><?= h($caCall->call_type) ?></td>
                    <td><?= h($caCall->recording_url) ?></td>
                    <td><?= $this->Number->format($caCall->recording_duration) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $caCall->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $caCall->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $caCall->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCall->id)]) ?>
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
