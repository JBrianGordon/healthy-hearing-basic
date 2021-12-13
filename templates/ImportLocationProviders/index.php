<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocationProvider[]|\Cake\Collection\CollectionInterface $importLocationProviders
 */
?>
<div class="importLocationProviders index content">
    <?= $this->Html->link(__('New Import Location Provider'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Import Location Providers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('import_id') ?></th>
                    <th><?= $this->Paginator->sort('import_location_id') ?></th>
                    <th><?= $this->Paginator->sort('import_provider_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importLocationProviders as $importLocationProvider): ?>
                <tr>
                    <td><?= $this->Number->format($importLocationProvider->id) ?></td>
                    <td><?= $importLocationProvider->has('import') ? $this->Html->link($importLocationProvider->import->id, ['controller' => 'Imports', 'action' => 'view', $importLocationProvider->import->id]) : '' ?></td>
                    <td><?= $importLocationProvider->has('import_location') ? $this->Html->link($importLocationProvider->import_location->title, ['controller' => 'ImportLocations', 'action' => 'view', $importLocationProvider->import_location->id]) : '' ?></td>
                    <td><?= $importLocationProvider->has('import_provider') ? $this->Html->link($importLocationProvider->import_provider->id, ['controller' => 'ImportProviders', 'action' => 'view', $importLocationProvider->import_provider->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $importLocationProvider->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $importLocationProvider->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $importLocationProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocationProvider->id)]) ?>
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
