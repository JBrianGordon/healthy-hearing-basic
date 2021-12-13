<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocation $importLocation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Import Location'), ['action' => 'edit', $importLocation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Import Location'), ['action' => 'delete', $importLocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Import Locations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Import Location'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importLocations view content">
            <h3><?= h($importLocation->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Import') ?></th>
                    <td><?= $importLocation->has('import') ? $this->Html->link($importLocation->import->id, ['controller' => 'Imports', 'action' => 'view', $importLocation->import->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id External') ?></th>
                    <td><?= h($importLocation->id_external) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $importLocation->has('location') ? $this->Html->link($importLocation->location->title, ['controller' => 'Locations', 'action' => 'view', $importLocation->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Oticon') ?></th>
                    <td><?= h($importLocation->id_oticon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($importLocation->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtitle') ?></th>
                    <td><?= h($importLocation->subtitle) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($importLocation->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($importLocation->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address 2') ?></th>
                    <td><?= h($importLocation->address_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($importLocation->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($importLocation->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($importLocation->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($importLocation->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($importLocation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Match Type') ?></th>
                    <td><?= $this->Number->format($importLocation->match_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Retail') ?></th>
                    <td><?= $importLocation->is_retail ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is New') ?></th>
                    <td><?= $importLocation->is_new ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Import Location Providers') ?></h4>
                <?php if (!empty($importLocation->import_location_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Import Location Id') ?></th>
                            <th><?= __('Import Provider Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($importLocation->import_location_providers as $importLocationProviders) : ?>
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
