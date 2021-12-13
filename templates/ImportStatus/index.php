<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportStatus[]|\Cake\Collection\CollectionInterface $importStatus
 */
?>
<div class="importStatus index content">
    <?= $this->Html->link(__('New Import Status'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Import Status') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('oticon_tier') ?></th>
                    <th><?= $this->Paginator->sort('listing_type') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_show') ?></th>
                    <th><?= $this->Paginator->sort('is_grace_period') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importStatus as $importStatus): ?>
                <tr>
                    <td><?= $this->Number->format($importStatus->id) ?></td>
                    <td><?= $importStatus->has('location') ? $this->Html->link($importStatus->location->title, ['controller' => 'Locations', 'action' => 'view', $importStatus->location->id]) : '' ?></td>
                    <td><?= $this->Number->format($importStatus->status) ?></td>
                    <td><?= $this->Number->format($importStatus->oticon_tier) ?></td>
                    <td><?= h($importStatus->listing_type) ?></td>
                    <td><?= h($importStatus->is_active) ?></td>
                    <td><?= h($importStatus->is_show) ?></td>
                    <td><?= h($importStatus->is_grace_period) ?></td>
                    <td><?= h($importStatus->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $importStatus->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $importStatus->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $importStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importStatus->id)]) ?>
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
