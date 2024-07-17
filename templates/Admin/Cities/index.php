<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\City[]|\Cake\Collection\CollectionInterface $cities
 */
$queryParams = $this->request->getQueryParams();
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    $placeholder = null;
    if (in_array($type, ['date', 'datetime'])) {
        $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
        $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
    }
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value,
        'placeholder' => $placeholder
    ];
}

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Cities Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2><?= __('Cities') ?></h2>
				<div class="cities index">
				    <?= $this->element('pagination') ?>
					<?= $this->element('admin_filter', ['modelName' => 'city']) ?>
					<?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
				    <div class="table-responsive">
				        <table class="table table-striped table-bordered table-sm">
				            <thead>
				                <tr>
				                    <th><?= $this->Paginator->sort('city') ?></th>
				                    <th><?= $this->Paginator->sort('state') ?></th>
				                    <th><?= $this->Paginator->sort('lon') ?></th>
				                    <th><?= $this->Paginator->sort('lat') ?></th>
				                    <th><?= $this->Paginator->sort('country') ?></th>
				                    <th><?= $this->Paginator->sort('population') ?></th>
				                    <th><?= $this->Paginator->sort('is_near_location') ?></th>
				                    <th class="actions"><?= __('Actions') ?></th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php foreach ($cities as $city): ?>
				                <tr>
				                    <td class="p5">
				                        <?= $this->Html->link($city->city,
				                            [
				                                'prefix' => false,
				                                'controller' => 'locations',
				                                'action' => 'viewCityZip',
				                                'city' => $city->city,
				                                'region' =>  $this->Clinic->stateSlug($city->state)
				                            ])
				                        ?>
				                    </td>
				                    <td class="p5"><?= h($city->state) ?></td>
				                    <td class="p5"><?= $this->Number->format($city->lon) ?></td>
				                    <td class="p5"><?= $this->Number->format($city->lat) ?></td>
				                    <td class="p5"><?= h($city->country) ?></td>
				                    <td class="p5"><?= $this->Number->format($city->population) ?></td>
				                    <td class="p5">
				                        <?=
				                            $this->Html->badge(
				                                $city->is_near_location ? ' Yes' : ' No',
				                                [
				                                    'class' => $city->is_near_location ? 'success bi bi-check-lg' : 'danger bi bi-x-lg',
				                                ]
				                            );
				                        ?>
				                    </td>
				                    <td class="actions p5">
				                        <div class="btn-group-vertical btn-group-sm">
				                            <?= $this->Html->link(__('Edit'),
				                                ['action' => 'edit', $city->id],
				                                ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
				                            <?= $this->Form->postLink(__('Delete'),
				                                ['action' => 'delete', $city->id],
				                                ['class' => 'btn btn-xs btn-danger bi bi-trash', 'confirm' => __('Are you sure you want to delete {0}?', $city->city)]) ?>
				                        </div>
				                    </td>
				                </tr>
				                <?php endforeach; ?>
				            </tbody>
				        </table>
				    </div>
				    <?= $this->element('pagination') ?>
				</div>
			</div>
		</div>
	</section>
</div>