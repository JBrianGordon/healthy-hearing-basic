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
        'value' => $value
    ];
}

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="clear"></div>
				<header class="col-md-12 mt10">
					<div class="panel panel-light">
						<div class="panel-heading">Zips Actions</div>
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
								<h2>ZIP Codes</h2>
								<div class="zips index content">
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
								    <div class="table-responsive">
								        <table class="table table-striped table-bordered table-sm mb30">
								            <thead>
								                <tr>
								                    <th class="p5"><?= $this->Paginator->sort('zip', ['label' => 'ZIP']) ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('lat') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('lon') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('city') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('state') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('areacode') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('country_code') ?></th>
								                    <th class="actions p5"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($zips as $zip): ?>
								                <tr>
								                    <td class="p5">
									                    <span class="label label-default">
									                        <?= $this->Html->link($zip->zip,
									                            [
									                                'prefix' => false,
									                                'controller' => 'locations',
									                                'action' => 'viewCityZip',
									                                'zip' => $zip->zip,
									                                'city' => $zip->city,
									                                'region' =>  $this->Clinic->stateSlug($zip->state)
									                            ])
									                        ?>
									                    </span>
								                    </td>
								                    <td class="p5"><?= $this->Number->format($zip->lat) ?></td>
								                    <td class="p5"><?= $this->Number->format($zip->lon) ?></td>
								                    <td class="p5"><?= h($zip->city) ?></td>
								                    <td class="p5"><?= h($zip->state) ?></td>
								                    <td class="p5"><?= h($zip->areacode) ?></td>
								                    <td class="p5"><?= h($zip->country_code) ?></td>
								                    <td class="actions p5">
								                        <div class="btn-group-vertical btn-group-sm">
								                            <?= $this->Html->link(__(' Edit'),
								                                ['action' => 'edit', $zip->zip],
								                                ['class' => 'btn btn-xs btn-default bi bi-pencil-fill']) ?>
								                            <?= $this->Form->postLink(__(' Delete'),
								                                ['action' => 'delete', $zip->zip],
								                                ['class' => 'btn btn-xs btn-danger bi bi-trash', 'confirm' => __('Are you sure you want to delete {0}?', $zip->zip)]) ?>
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
			</div>
		</div>
	</div>
</div>
