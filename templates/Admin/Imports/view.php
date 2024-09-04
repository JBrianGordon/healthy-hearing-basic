<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import $import
 */
use Cake\Core\Configure;
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
                    <th>Type</th>
                    <td><?= h($import->type) ?></td>
                </tr>
                <tr>
                    <th>Id</th>
                    <td><?= $this->Number->format($import->id) ?></td>
                </tr>
                <tr>
                    <th>Total Locations</th>
                    <td><?= $import->total_locations === null ? '' : $this->Number->format($import->total_locations) ?></td>
                </tr>
                <tr>
                    <th>New Locations</th>
                    <td><?= $import->new_locations === null ? '' : $this->Number->format($import->new_locations) ?></td>
                </tr>
                <tr>
                    <th>Updated Locations</th>
                    <td><?= $import->updated_locations === null ? '' : $this->Number->format($import->updated_locations) ?></td>
                </tr>
                <tr>
                    <th>Total Providers</th>
                    <td><?= $import->total_providers === null ? '' : $this->Number->format($import->total_providers) ?></td>
                </tr>
                <tr>
                    <th>New Providers</th>
                    <td><?= $import->new_providers === null ? '' : $this->Number->format($import->new_providers) ?></td>
                </tr>
                <tr>
                    <th>Updated Providers</th>
                    <td><?= $import->updated_providers === null ? '' : $this->Number->format($import->updated_providers) ?></td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td><?= h($import->created) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4>Related Import Diffs</h4>
                <?php if (!empty($import->import_diffs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Import Id</th>
                            <th>Model</th>
                            <th>Id Model</th>
                            <th>Field</th>
                            <th>Value</th>
                            <th>Review Needed</th>
                            <th>Created</th>
                            <th class="actions">Actions</th>
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
                                <?= $this->Html->link('View', ['controller' => 'ImportDiffs', 'action' => 'view', $importDiffs->id]) ?>
                                <?= $this->Html->link('Edit', ['controller' => 'ImportDiffs', 'action' => 'edit', $importDiffs->id]) ?>
                                <?= $this->Form->postLink('Delete', ['controller' => 'ImportDiffs', 'action' => 'delete', $importDiffs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importDiffs->id)]) ?>
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
                            <th>Id</th>
                            <th>Import Id</th>
                            <th>Import Location Id</th>
                            <th>Import Provider Id</th>
                            <th class="actions">Actions</th>
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
                <h4>Related Import Locations</h4>
                <?php if (!empty($import->import_locations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Import Id</th>
                            <th>Id External</th>
                            <th>Location Id</th>
                            <th>Id Oticon</th>
                            <th>Cqp Practice Id</th>
                            <th>Cqp Office Id</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Address 2</th>
                            <th>City</th>
                            <th>State</th>
                            <th><?= Configure::read('zipLabel') ?></th>
                            <th>Phone</th>
                            <th>Match Type</th>
                            <th>Is Retail</th>
                            <th>Is New</th>
                            <th>Notes</th>
                            <th class="actions">Actions</th>
                        </tr>
                        <?php foreach ($import->import_locations as $importLocations) : ?>
                        <tr>
                            <td><?= h($importLocations->id) ?></td>
                            <td><?= h($importLocations->import_id) ?></td>
                            <td><?= h($importLocations->id_external) ?></td>
                            <td><?= h($importLocations->location_id) ?></td>
                            <td><?= h($importLocations->id_oticon) ?></td>
                            <td><?= h($importLocations->id_cqp_practice) ?></td>
                            <td><?= h($importLocations->id_cqp_office) ?></td>
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
