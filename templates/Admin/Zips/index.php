<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zip[]|\Cake\Collection\CollectionInterface $zips
 */

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
?>
<div class="zips index content">
    <?= $this->Html->link(__('New Zip'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Zips') ?></h3>
    <?= $this->element('pagination') ?>
    <div class="row justify-content-end">
        <?php if ($this->Search->isSearch()) : ?>
            <div class="col col-md-auto">
                <?= $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-info text-light', 'role' => 'button']) ?>
            </div>
        <?php endif; ?>
        <div class="col col-md-auto">
            <button class="btn btn-primary mb-3" type="button"
                data-bs-toggle="collapse" data-bs-target="#advancedSearch"
                aria-expanded="false" aria-controls="advancedSearch"
            >
                + Advanced
            </button>
        </div>
    </div>
    <div class="collapse" id="advancedSearch">
        <?php
            echo $this->Form->create(null, [
                'class' => 'bg-light mb-3 p-5',
                'valueSources' => 'query',
            ]);
            echo $this->Form->control('zip', [
                'type' => 'text',
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('city', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('state', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('country_code', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('lat', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('lon', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('areacode', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->button('Filter', [
                'type' => 'submit',
                'class' => 'me-3',
            ]);
            echo $this->Form->end();
            ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('lon') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('areacode') ?></th>
                    <th><?= $this->Paginator->sort('country_code') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zips as $zip): ?>
                <tr>
                    <td>
                        <?= $this->Html->link($zip->zip,
                            [
                                'prefix' => false,
                                'controller' => 'locations',
                                'action' => 'index',
                                'zip' => $zip->zip,
                                'city' => $zip->city,
                                'region' => $zip->state,
                                // TODO:
                                //'region' =>  $this->Clinic->stateSlug($city->state)
                            ])
                        ?>
                    </td>
                    <td><?= $this->Number->format($zip->lat) ?></td>
                    <td><?= $this->Number->format($zip->lon) ?></td>
                    <td><?= h($zip->city) ?></td>
                    <td><?= h($zip->state) ?></td>
                    <td><?= h($zip->areacode) ?></td>
                    <td><?= h($zip->country_code) ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical btn-group-sm">
                            <?= $this->Html->link(__('Edit'),
                                ['action' => 'edit', $zip->zip],
                                ['class' => 'btn btn-default']) ?>
                            <?= $this->Form->postLink(__('Delete'),
                                ['action' => 'delete', $zip->zip],
                                ['class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete {0}?', $zip->zip)]) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
