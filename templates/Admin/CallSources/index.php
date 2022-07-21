<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CallSource[]|\Cake\Collection\CollectionInterface $callSources
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
<div class="callSources index">
    <h3><?= __('CallSource Numbers') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('customer_name') ?> <?= $this->Paginator->sort('location_id', 'Location') ?></th>
                    <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
                    <th><?= $this->Paginator->sort('phone_number', 'CS phone') ?></th>
                    <th><?= $this->Paginator->sort('target_number', 'Target') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($callSources as $callSource): ?>
                <tr>
                    <td><?= $callSource->id; ?></td>
                    <td><?= h($callSource->customer_name) ?><br>
                        <?= $this->Html->link($callSource->location->title,
                            [
                                'prefix' => 'Admin',
                                'controller' => 'Locations',
                                'action' => 'edit',
                                $callSource->location_id,
                            ])
                        ?><br>
                        <?= h($callSource->location->city).', '.h($callSource->location->state) ?>
                    </td>
                    <td><?php echo $callSource->is_active ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Active</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> Inactive</span>"; ?>
                    </td>
                    <td><?= h($callSource->phone_number) ?></td>
                    <td><?= h($callSource->target_number) ?></td>
                    <td><?= date('m/d/Y', strtotime($callSource->created)) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
