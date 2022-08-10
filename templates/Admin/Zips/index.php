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
$queryParams = $this->request->getQueryParams();
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value
    ];
}
?>
<div class="zips index content">
    <?= $this->Html->link(__('New Zip'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Zips') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
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
