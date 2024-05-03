<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportProvider $importProvider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Import Provider'), ['action' => 'edit', $importProvider->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Import Provider'), ['action' => 'delete', $importProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importProvider->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Import Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Import Provider'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importProviders view content">
            <h3><?= h($importProvider->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Import') ?></th>
                    <td><?= $importProvider->has('import') ? $this->Html->link($importProvider->import->id, ['controller' => 'Imports', 'action' => 'view', $importProvider->import->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Provider') ?></th>
                    <td><?= $importProvider->has('provider') ? $this->Html->link($importProvider->provider->title, ['controller' => 'Providers', 'action' => 'view', $importProvider->provider->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($importProvider->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($importProvider->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($importProvider->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Aud Or His') ?></th>
                    <td><?= h($importProvider->aud_or_his) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($importProvider->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id External') ?></th>
                    <td><?= $this->Number->format($importProvider->id_external) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Import Location Providers') ?></h4>
                <?php if (!empty($importProvider->import_location_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Import Location Id') ?></th>
                            <th><?= __('Import Provider Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($importProvider->import_location_providers as $importLocationProviders) : ?>
                        <tr>
                            <td><?= h($importLocationProviders->id) ?></td>
                            <td><?= h($importLocationProviders->import_id) ?></td>
                            <td><?= h($importLocationProviders->import_location_id) ?></td>
                            <td><?= h($importLocationProviders->import_provider_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportLocationProviders', 'action' => 'view', $importLocationProviders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportLocationProviders', 'action' => 'edit', $importLocationProviders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportLocationProviders', 'action' => 'delete', $importLocationProviders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocationProviders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
