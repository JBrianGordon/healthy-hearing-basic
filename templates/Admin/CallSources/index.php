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
						<div class="panel-heading">Call Sources Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
								<?= $this->Html->link(__(' Export'), ['action' => 'export.csv'], ['class' => 'btn btn-default bi bi-download']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2>CallSource Numbers</h2>
								<div class="callSources index">
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
								    <div class="table-responsive">
								        <table class="table table-striped table-bordered table-sm">
								            <thead>
								                <tr>
								                    <th><?= $this->Paginator->sort('id') ?></th>
								                    <th><?= $this->Paginator->sort('customer_name') ?><br><?= $this->Paginator->sort('location_id', 'Location') ?></th>
								                    <th><?= $this->Paginator->sort('is_active', 'Active') ?>/<br><?= $this->Paginator->sort('is_show', 'Show') ?></th>
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
								                    <td><?php echo $callSource->is_active ? "<span class='badge bg-success bi bi-check-lg'> Active</span>" : "<span class='badge bg-danger bi bi-x-lg'> Inactive</span>"; ?><br>
														<?php echo $callSource->location->is_show ? "<span class='badge bg-success bi bi-check-lg'> Show</span>" : "<span class='badge bg-danger bi bi-x-lg'> No Show</span>"; ?>
								                    </td>
								                    <td><?= '(' . substr($callSource->phone_number, 0, 3) . ') ' . substr($callSource->phone_number, 3, 3) . '-' . substr($callSource->phone_number, 6) ?></td>
								                    <td><?= '(' . substr($callSource->target_number, 0, 3) . ') ' . substr($callSource->target_number, 3, 3) . '-' . substr($callSource->target_number, 6) ?></td>
								                    <td><?= date('m/d/Y', strtotime($callSource->created)) ?></td>
								                </tr>
								                <?php endforeach; ?>
								            </tbody>
								        </table>
								    </div>
								    <?= $this->element('pagination') ?>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
