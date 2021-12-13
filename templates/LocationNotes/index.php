<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationNote[]|\Cake\Collection\CollectionInterface $locationNotes
 */
?>
<div class="locationNotes index content">
    <?= $this->Html->link(__('New Location Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationNotes as $locationNote): ?>
                <tr>
                    <td><?= $this->Number->format($locationNote->id) ?></td>
                    <td><?= $locationNote->has('location') ? $this->Html->link($locationNote->location->title, ['controller' => 'Locations', 'action' => 'view', $locationNote->location->id]) : '' ?></td>
                    <td><?= $this->Number->format($locationNote->status) ?></td>
                    <td><?= $locationNote->has('user') ? $this->Html->link($locationNote->user->id, ['controller' => 'Users', 'action' => 'view', $locationNote->user->id]) : '' ?></td>
                    <td><?= h($locationNote->created) ?></td>
                    <td><?= h($locationNote->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationNote->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationNote->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationNote->id)]) ?>
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
