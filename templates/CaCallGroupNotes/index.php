<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroupNote[]|\Cake\Collection\CollectionInterface $caCallGroupNotes
 */
?>
<div class="caCallGroupNotes index content">
    <?= $this->Html->link(__('New Ca Call Group Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Ca Call Group Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('ca_call_group_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($caCallGroupNotes as $caCallGroupNote): ?>
                <tr>
                    <td><?= $this->Number->format($caCallGroupNote->id) ?></td>
                    <td><?= $caCallGroupNote->has('ca_call_group') ? $this->Html->link($caCallGroupNote->ca_call_group->id, ['controller' => 'CaCallGroups', 'action' => 'view', $caCallGroupNote->ca_call_group->id]) : '' ?></td>
                    <td><?= h($caCallGroupNote->status) ?></td>
                    <td><?= $caCallGroupNote->has('user') ? $this->Html->link($caCallGroupNote->user->id, ['controller' => 'Users', 'action' => 'view', $caCallGroupNote->user->id]) : '' ?></td>
                    <td><?= h($caCallGroupNote->created) ?></td>
                    <td><?= h($caCallGroupNote->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $caCallGroupNote->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $caCallGroupNote->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $caCallGroupNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroupNote->id)]) ?>
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
