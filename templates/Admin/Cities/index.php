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
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty
    ];
}
?>
<div class="cities index">
    <?= $this->Html->link(__('New City'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cities') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
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
                                'action' => 'index',
                                'city' => $city->city,
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
                        <div class="btn-group-vertical btn-group-sm">
                            <?= $this->Html->link(__('Edit'),
                                ['action' => 'edit', $city->id],
                                ['class' => 'btn btn-default']) ?>
                            <?= $this->Form->postLink(__('Delete'),
                                ['action' => 'delete', $city->id],
                                ['class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete {0}?', $city->city)]) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
