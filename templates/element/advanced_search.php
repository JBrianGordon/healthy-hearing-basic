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
        'empty',
        'value',
        'placeholder'
    ],
    '1' => [
        'checkboxGroupName',
        'checkboxFields' => [
            '0' => [
                'field',
                'type',
                'label',
                'options',
                'empty',
                'value',
                'placeholder'
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
            'empty',
            'value',
            'placeholder'
        ],
        ...
    ]
]
*/
use Cake\Core\Configure;
use App\Model\Entity\Location;
use Cake\Utility\Inflector;

$additionalBlacklist = isset($additionalBlacklist) ? $additionalBlacklist : [];
$additionalBlacklist[] = 'saved_search';
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => $additionalBlacklist,
]);
?>
<div class="row justify-content-end">
    <?php if ($this->Search->isSearch()) : ?>
            <div class="col col-md-auto p-0">
                Showing search results.
                <?= $this->Html->link('Clear Search', ['?'=> ['preserve' => 0]]) ?>
            </div>
    <?php endif; ?>
    <div class="col col-md-auto mb20">
        <span class="btn btn-primary btn-sm mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#advanced_search" aria-expanded="false" aria-controls="advanced_search">
            + Advanced
        </span>
    </div>
</div>
<div class="collapse well blue-well" id="advanced_search">
    <?= $this->Form->create(null, ['class' => 'mb-2','valueSources' => 'query']) ?>
    <!-- GROUPED FIELDS -->
    <?php if (!empty($groupedFields)): ?>
        <?php foreach ($groupedFields as $groupName => $groupFields): ?>
            <?php $groupNameReadable = ucfirst(Inflector::delimit($groupName, ' ')); ?>
            <?php if (!empty($groupFields)): ?>
                <div class="col col-md-auto">
	                <h3 class="crm-group-header"><?= $groupNameReadable ?></h3>
                    <button class="btn btn-sm btn-primary mb20 group-toggle" type="button" style="min-width:178px;"><span class="bi-plus-lg"> Expand section</span></button>
                </div>
                <div class="mb-3 filter-group<?= $groupName == "generalDemographics" ? "" : " hidden"?>" id="<?= $groupName ?>" style="border:2px solid #a3a3a3;padding:20px;">
                    <?php $column = 1; ?>
                    <?php foreach ($groupFields as $field): ?>
                        <?php $formInput = $this->Admin->formInput($field['field'], $field['type'], $field['label'], $field['options'], $field['empty'], $field['value'], $field['placeholder']); ?>
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
    <?php if (!empty($fields)): ?>
	    <!-- ALL OTHER FIELDS -->
	    <div class="filter-group">
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
	                <?php $formInput = $this->Admin->formInput($field['field'], $field['type'], $field['label'], $field['options'], $field['empty'], $field['value'], $field['placeholder']); ?>
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
		</div>
	<?php endif; ?>
    <?php
    echo $this->Form->button('Search', [
        'type' => 'submit',
        'class' => 'me-3 btn-primary',
    ]);
    echo $this->Form->end();
    ?>
</div>

