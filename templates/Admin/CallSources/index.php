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
?>
<div class="callSources index">
    <h3><?= __('CallSource Numbers') ?></h3>
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
        ?>
        <?php $column = 1; ?>
        <?php foreach ($fields as $field => $type): ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?php echo $this->Admin->formInput($field, $type); ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?php echo $this->Admin->formInput($field, $type); ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
        <?php
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
