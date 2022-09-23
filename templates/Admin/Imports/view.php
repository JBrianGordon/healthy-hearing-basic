<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import $import
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Import'), ['action' => 'edit', $import->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Import'), ['action' => 'delete', $import->id], ['confirm' => __('Are you sure you want to delete # {0}?', $import->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Imports'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Import'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="imports view content">
            <h3><?= h($import->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($import->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($import->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Locations') ?></th>
                    <td><?= $import->total_locations === null ? '' : $this->Number->format($import->total_locations) ?></td>
                </tr>
                <tr>
                    <th><?= __('New Locations') ?></th>
                    <td><?= $import->new_locations === null ? '' : $this->Number->format($import->new_locations) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated Locations') ?></th>
                    <td><?= $import->updated_locations === null ? '' : $this->Number->format($import->updated_locations) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Providers') ?></th>
                    <td><?= $import->total_providers === null ? '' : $this->Number->format($import->total_providers) ?></td>
                </tr>
                <tr>
                    <th><?= __('New Providers') ?></th>
                    <td><?= $import->new_providers === null ? '' : $this->Number->format($import->new_providers) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated Providers') ?></th>
                    <td><?= $import->updated_providers === null ? '' : $this->Number->format($import->updated_providers) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($import->created) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Import Diffs') ?></h4>
                <?php if (!empty($import->import_diffs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('Id Model') ?></th>
                            <th><?= __('Field') ?></th>
                            <th><?= __('Value') ?></th>
                            <th><?= __('Review Needed') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($import->import_diffs as $importDiffs) : ?>
                        <tr>
                            <td><?= h($importDiffs->id) ?></td>
                            <td><?= h($importDiffs->import_id) ?></td>
                            <td><?= h($importDiffs->model) ?></td>
                            <td><?= h($importDiffs->id_model) ?></td>
                            <td><?= h($importDiffs->field) ?></td>
                            <td><?= h($importDiffs->value) ?></td>
                            <td><?= h($importDiffs->review_needed) ?></td>
                            <td><?= h($importDiffs->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportDiffs', 'action' => 'view', $importDiffs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportDiffs', 'action' => 'edit', $importDiffs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportDiffs', 'action' => 'delete', $importDiffs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importDiffs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Import Location Providers') ?></h4>
                <?php if (!empty($import->import_location_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Import Location Id') ?></th>
                            <th><?= __('Import Provider Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($import->import_location_providers as $importLocationProviders) : ?>
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
            <div class="related">
                <h4><?= __('Related Import Locations') ?></h4>
                <?php if (!empty($import->import_locations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Id External') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Id Oticon') ?></th>
                            <th><?= __('Cqp Practice Id') ?></th>
                            <th><?= __('Cqp Office Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Subtitle') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Address 2') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('Zip') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Match Type') ?></th>
                            <th><?= __('Is Retail') ?></th>
                            <th><?= __('Is New') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($import->import_locations as $importLocations) : ?>
                        <tr>
                            <td><?= h($importLocations->id) ?></td>
                            <td><?= h($importLocations->import_id) ?></td>
                            <td><?= h($importLocations->id_external) ?></td>
                            <td><?= h($importLocations->location_id) ?></td>
                            <td><?= h($importLocations->id_oticon) ?></td>
                            <td><?= h($importLocations->cqp_practice_id) ?></td>
                            <td><?= h($importLocations->cqp_office_id) ?></td>
                            <td><?= h($importLocations->title) ?></td>
                            <td><?= h($importLocations->subtitle) ?></td>
                            <td><?= h($importLocations->email) ?></td>
                            <td><?= h($importLocations->address) ?></td>
                            <td><?= h($importLocations->address_2) ?></td>
                            <td><?= h($importLocations->city) ?></td>
                            <td><?= h($importLocations->state) ?></td>
                            <td><?= h($importLocations->zip) ?></td>
                            <td><?= h($importLocations->phone) ?></td>
                            <td><?= h($importLocations->match_type) ?></td>
                            <td><?= h($importLocations->is_retail) ?></td>
                            <td><?= h($importLocations->is_new) ?></td>
                            <td><?= h($importLocations->notes) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportLocations', 'action' => 'view', $importLocations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportLocations', 'action' => 'edit', $importLocations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportLocations', 'action' => 'delete', $importLocations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Import Providers') ?></h4>
                <?php if (!empty($import->import_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Id External') ?></th>
                            <th><?= __('Provider Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Aud Or His') ?></th>
                            <th><?= __('Caqh Number') ?></th>
                            <th><?= __('Npi Number') ?></th>
                            <th><?= __('Licenses') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($import->import_providers as $importProviders) : ?>
                        <tr>
                            <td><?= h($importProviders->id) ?></td>
                            <td><?= h($importProviders->import_id) ?></td>
                            <td><?= h($importProviders->id_external) ?></td>
                            <td><?= h($importProviders->provider_id) ?></td>
                            <td><?= h($importProviders->first_name) ?></td>
                            <td><?= h($importProviders->last_name) ?></td>
                            <td><?= h($importProviders->email) ?></td>
                            <td><?= h($importProviders->aud_or_his) ?></td>
                            <td><?= h($importProviders->caqh_number) ?></td>
                            <td><?= h($importProviders->npi_number) ?></td>
                            <td><?= h($importProviders->licenses) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportProviders', 'action' => 'view', $importProviders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportProviders', 'action' => 'edit', $importProviders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportProviders', 'action' => 'delete', $importProviders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importProviders->id)]) ?>
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
