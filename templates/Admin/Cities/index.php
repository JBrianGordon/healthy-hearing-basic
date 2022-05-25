<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\City[]|\Cake\Collection\CollectionInterface $cities
 */

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
?>
<div class="cities index">
    <?= $this->Html->link(__('New City'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cities') ?></h3>
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
            echo $this->Form->control('city', [
                'type' => 'text',
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('state', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('country', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('lat', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('lon', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('population', [
                'label' => ['floating' => true],
            ]);
            echo $this->Form->control('is_near_location', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)',
            ]);
            echo $this->Form->control('is_featured', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)',
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
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('lon') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('population') ?></th>
                    <th><?= $this->Paginator->sort('is_near_location') ?></th>
                    <th><?= $this->Paginator->sort('is_featured') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cities as $city): ?>
                <tr>
                    <td>
                        <?= $this->Html->link($city->city,
                            [
                                'prefix' => false,
                                'controller' => 'locations',
                                'action' => 'cities',
                                'region' => $city->state,
                                // TODO:
                                //'region' =>  $this->Clinic->stateSlug($city->state)
                            ])
                        ?>
                    </td>
                    <td><?= h($city->state) ?></td>
                    <td><?= h($city->country) ?></td>
                    <td><?= $this->Number->format($city->lon) ?></td>
                    <td><?= $this->Number->format($city->lat) ?></td>
                    <td><?= $this->Number->format($city->population) ?></td>
                    <td>
                        <?=
                            $this->Html->badge(
                                $city->is_near_location ? 'Yes' : 'No',
                                [
                                    'class' => $city->is_near_location ? 'success' : 'danger',
                                ]
                            );
                        ?>
                    </td>
                    <td>
                        <?=
                            $this->Html->badge(
                                $city->is_featured ? 'Yes' : 'No',
                                [
                                    'class' => $city->is_featured ? 'success' : 'danger',
                                ]
                            );
                        ?>
                    </td>
                    <td class="actions">
                        <div class="btn-group-vertical">
                            <?= $this->Html->link(__('View'),
                                [
                                    'prefix' => false,
                                    'controller' => 'locations',
                                    'action' => 'cities',
                                    'region' => $city->state,
                                    // TODO:
                                    //'region' =>  $this->Clinic->stateSlug($city->state)
                                ],
                                ['class' => 'btn btn-outline-secondary']) ?>
                            <?= $this->Html->link(__('Edit'),
                                ['action' => 'edit', $city->id],
                                ['class' => 'btn btn-outline-secondary']) ?>
                            <?= $this->Form->postLink(__('Delete'),
                                ['action' => 'delete', $city->id],
                                ['class' => 'btn btn-outline-secondary', 'confirm' => __('Are you sure you want to delete # {0}?', $city->id)]) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
