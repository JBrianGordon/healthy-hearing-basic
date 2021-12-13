<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocationProvider $importLocationProvider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Import Location Provider'), ['action' => 'edit', $importLocationProvider->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Import Location Provider'), ['action' => 'delete', $importLocationProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocationProvider->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Import Location Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Import Location Provider'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importLocationProviders view content">
            <h3><?= h($importLocationProvider->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Import') ?></th>
                    <td><?= $importLocationProvider->has('import') ? $this->Html->link($importLocationProvider->import->id, ['controller' => 'Imports', 'action' => 'view', $importLocationProvider->import->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Import Location') ?></th>
                    <td><?= $importLocationProvider->has('import_location') ? $this->Html->link($importLocationProvider->import_location->title, ['controller' => 'ImportLocations', 'action' => 'view', $importLocationProvider->import_location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Import Provider') ?></th>
                    <td><?= $importLocationProvider->has('import_provider') ? $this->Html->link($importLocationProvider->import_provider->id, ['controller' => 'ImportProviders', 'action' => 'view', $importLocationProvider->import_provider->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($importLocationProvider->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
