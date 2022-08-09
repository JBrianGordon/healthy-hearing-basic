<?php
/*
Advanced Search
Pass in the following (optional) data:
$fields = [
    '0' => [
        'field',
        'type',
        'label',
        'options',
        'empty'
    ],
    '1' => [
        'checkboxGroupName',
        'checkboxFields' => [
            '0' => [
                'field',
                'type',
                'label',
                'options',
                'empty'
            ],
        ]
    ]
    ...
];
$groupedFields = [
    'groupName' => [
        '0' => [
            'field',
            'type',
            'label',
            'options',
            'empty'
        ],
        ...
    ]
]
*/
use Cake\Core\Configure;
use App\Model\Entity\Location;
use Cake\Utility\Inflector;

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
?>

<div class="row justify-content-end">
    <?php if ($this->Search->isSearch()) : ?>
        <div class="col col-md-auto">
            <?= $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-info text-light', 'role' => 'button']) ?>
        </div>
    <?php endif; ?>
    <div class="col col-md-auto">
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#advancedSearch" aria-expanded="false" aria-controls="advancedSearch">
            + Advanced
        </button>
    </div>
</div>
<div class="collapse" id="advancedSearch">
    <?php
    echo $this->Form->create(null, [
        'class' => 'bg-light mb-2 p-4',
        'valueSources' => 'query',
    ]);
    ?>
    <!-- GROUPED FIELDS -->
    <?php if (!empty($groupedFields)): ?>
        <?php foreach ($groupedFields as $groupName => $groupFields): ?>
            <?php $groupNameReadable = ucfirst(Inflector::delimit($groupName, ' ')); ?>
            <?php if (!empty($groupFields)): ?>
                <div class="row justify-content-end">
                    <div class="col col-md-auto">
                        <button class="btn btn-sm btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $groupName ?>" aria-expanded="false" aria-controls="advancedSearch" style="min-width:178px;">+ <?= $groupNameReadable ?></button>
                    </div>
                </div>
                <div class="collapse mb-3" id="<?= $groupName ?>" style="border:2px solid #a3a3a3;padding:20px;">
                    <?php $column = 1; ?>
                    <?php foreach ($groupFields as $field): ?>
                        <?php $formInput = $this->Admin->formInput($field['field'], $field['type'], $field['label'], $field['options'], $field['empty']); ?>
                        <?php if ($column == 1): ?>
                            <div class="row" style="min-height: 74px;">
                                <div class="col-md-6">
                                    <?= $formInput ?>
                                    <?php $column = 2; ?>
                                </div> <!-- end col -->
                        <?php else: // column 2 ?>
                                <div class="col-md-6">
                                    <?= $formInput ?>
                                    <?php $column = 1; ?>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($column==2): ?>
                        </div> <!-- end row -->
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- ALL OTHER FIELDS -->
    <?php if (!empty($fields)): ?>
        <?php $column = 1; ?>
        <?php foreach ($fields as $field): ?>
            <?php if (!empty($field['checkboxGroupName'])): ?>
                <!-- Checkbox groups will span whole row, so always start on column 1 -->
                <?php if ($column==2): ?>
                    </div> <!-- end row -->
                <?php endif; ?>
                <?php $formInput = $this->Admin->checkboxGroup($field['checkboxGroupName'], $field['checkboxFields']); ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-12">
                        <?= $formInput ?>
                        <?php $column==1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php else: ?>
                <?php $formInput = $this->Admin->formInput($field['field'], $field['type'], $field['label'], $field['options'], $field['empty']); ?>
                <?php if ($column == 1): ?>
                    <div class="row" style="min-height: 74px;">
                        <div class="col-md-6">
                            <?= $formInput ?>
                            <?php $column = 2; ?>
                        </div> <!-- end col -->
                <?php else: // column 2 ?>
                        <div class="col-md-6">
                            <?= $formInput ?>
                            <?php $column = 1; ?>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
    <?php endif; ?>
    <?php
    echo $this->Form->button('Search', [
        'type' => 'submit',
        'class' => 'me-3 btn-primary',
    ]);
    echo $this->Form->end();
    ?>
</div>

