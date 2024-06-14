<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocation[]|\Cake\Collection\CollectionInterface $importLocations
 */
use Cake\Core\Configure;
use App\Model\Entity\Import;

$queryParams = $this->request->getQueryParams();
$externalIdLabel = Configure::read('isYhnImportEnabled') ? 'YHN ID' : 'External ID / Retail ID';
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = [];
// Add additional fields
$fields['Imports.type'] = 'string';
$fields['Locations[is_junk]'] = 'boolean';
$fields['Locations[review_needed]'] = 'boolean';
$additionalBlacklist = ['Imports', 'Locations'];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
        $placeholder = null;
        if (in_array($type, ['date', 'datetime'])) {
            $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
            $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
        }
        switch ($field) {
            case 'Imports.type':
                $label = 'Import Type';
                $type = 'select';
                $empty = '(select one)';
                $options = Import::$importTypes;
                break;
            case 'Locations[is_junk]':
                $label = 'Is junk';
                $value = isset($queryParams['Locations']['is_junk']) ? $queryParams['Locations']['is_junk'] : null;
                break;
            case 'Locations[review_needed]':
                $label = 'Review needed';
                $value = isset($queryParams['Locations']['review_needed']) ? $queryParams['Locations']['review_needed'] : null;
                break;
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
}

$this->Html->script('dist/admin_index_import.min', ['block' => true]);
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
						<div class="panel-heading">Imports Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(" Dashboard", ['action' => 'index'], ['class' => 'btn btn-default bi bi-speedometer', 'escape' => false]) ?>
								<?= $this->Html->link(" Stats", ['controller' => 'imports', 'action' => 'index'], ['class' => 'btn btn-default bi bi-bar-chart-fill', 'escape' => false]) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2>Import Dashboard</h2>
								
								<div class="importLocations index content">
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields, 'additionalBlacklist' => $additionalBlacklist]) ?>
								    <!-- Overwrite _searchParams here so it doesn't save the current import_id -->
								    <?= $this->element('crm_search', ['crmSearches' => $crmSearches, '_searchParams' => $queryParams]) ?>
								    <?php
								        if (Configure::read('isCqpImportEnabled')) {
								            $importTypes = ['all', 'yhn', 'cqp'];
								            $importTypeLinks = [];
								            foreach ($importTypes as $importType) {
								                $newQuery = $queryParams;
								                $newQuery['Imports']['type'] = $importType;
								                $friendlyType = strtoupper($importType);
								                if ($importType == 'all') {
								                    unset($newQuery['Imports']['type']);
								                    $friendlyType = 'All';
								                }
								                if ($selectedImportType == $importType) {
								                    $importTypeLinks[] = $friendlyType;
								                } else {
								                    $importTypeLinks[] = $this->Html->link(
								                        $friendlyType,
								                        [
								                            'controller' => 'import-locations',
								                            'action' => 'index',
								                            '?' => $newQuery,
								                        ]
								                    );
								                }
								            }
								            echo 'Import type: '.implode(' &bull; ', $importTypeLinks).'<br>';
								        }
								        $filters = ['all', 'unlinked', 'review-needed', 'reviewed', 'junk'];
								        $filterLinks = [];
								        foreach ($filters as $filter) {
								            $newQuery = $queryParams;
								            $newQuery['filter'] = $filter;
								            if ($filter == 'all') {
								                unset($newQuery['filter']);
								            }
								            $friendlyFilter = ucfirst(str_replace('-', ' ', $filter));
								            if ($selectedFilter == $filter) {
								                $filterLinks[] = $friendlyFilter;
								            } else {
								                $filterLinks[] = $this->Html->link(
								                    $friendlyFilter,
								                    [
								                        'controller' => 'import-locations',
								                        'action' => 'index',
								                        '?' => $newQuery,
								                    ]
								                );
								            }
								        }
								        echo 'Filter: '.implode(' &bull; ', $filterLinks);
								    ?>
								    <div class="table-responsive">
								        <table class="table table-bordered table-sm">
								            <thead>
								                <tr>
									                <!-- *** TODO: Test out sorting when DB is updated and controller further built out *** -->
								                    <th class="p5"><?= $this->Paginator->sort('import_id', ['label' => 'Import ID']) ?><br><?= $this->Paginator->sort('type') ?><br><?= $this->Paginator->sort('created') ?></th>
								                    <th class="p5" style="min-width:300px"><?= $this->Paginator->sort('title') ?></th>
								                    <th class="p5" nowrap>
								                        <?php if (Configure::read('isCqpImportEnabled')): ?>
								                            Linked HH ID<br>External IDs
								                        <?php else: ?>
								                            Oticon ID /<br><?= $externalIdLabel ?>
								                        <?php endif; ?>
								                    </th>
								                    <th class="p5"><?= $this->Paginator->sort('address') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('city') ?>, <?= $this->Paginator->sort('state', ucwords($stateLabel)) ?></th>
								                    <th class="p5" style="min-width: 110px"><?= ucwords($zipShort) ?></th>
								                    <th class="actions p5"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($importLocations as $importLocation): ?>
								                    <?php
								                    $trId = 'YHN'.$importLocation->id;
								                    if (!empty($importLocation->location->is_junk)) {
								                        $trClass = 'status-junk';
								                    } else if (!empty($importLocation->location->review_needed)) {
								                        $trClass = 'status-review-needed';
								                    } else if (!empty($importLocation->location_id)) {
								                        $trClass = 'status-reviewed';
								                    } else {
								                        $trClass = 'status-unlinked';
								                    }
								                    ?>
								                    <tr id="<?= $trId ?>" class="<?= $trClass ?>">
								                        <td class="p5">
								                            <span class="badge bg-primary"><?= $importLocation->import_id ?></span>
								                            <?php if (Configure::read('isCqpImportEnabled')): ?>
								                                <?php $badgeType = ($importLocation->import->type == 'cqp') ? 'bg-cqp' : 'bg-yhn'; ?>
								                                    <span class="badge <?= $badgeType ?>"><?= strtoupper($importLocation->import->type) ?></span>
								                            <?php endif; ?>
								                            <br>
								                            <?= date('m/d/Y', strtotime($importLocation->import->created)) ?>
								                        </td>
								                        <td class="p5">
								                            <?php if (!empty($importLocation->location_id)): ?>
								                                <a target="_blank" href="/admin/locations/edit/<?= $importLocation->location_id ?>">
								                                    <?= $importLocation->title ?><br>
								                                    <?= $importLocation->subtitle ?>
								                                </a>
								                            <?php else: ?>
								                                <?php if ($importLocation->is_new): ?>
								                                    <span class="badge bg-success"><span class="glyphicon glyphicon-leaf"></span> New</span>
								                                <?php endif; ?>
								                                <?= $importLocation->title ?><br>
								                                <?= $importLocation->subtitle ?>
								                            <?php endif; ?>
								                        </td>
								                        <td class="p5">
								                            <?php if (!empty($importLocation->location_id)): ?>
								                                <span class="badge bg-hh"><?= $importLocation->location_id ?></span><br>
								                            <?php endif; ?>
								                            <?php if (!empty($importLocation->id_oticon)): ?>
								                                <span class="badge bg-oticon"><?= $importLocation->id_oticon ?></span><br>
								                            <?php endif; ?>
								                            <?php if (!empty($importLocation->id_external)): ?>
								                                <span class="badge bg-yhn"><?= $importLocation->id_external ?></span><br>
								                            <?php endif; ?>
								                            <?php if (!empty($importLocation->id_cqp_practice)): ?>
								                                <span class="badge bg-cqp"><?= $importLocation->id_cqp_practice ?></span><br>
								                            <?php endif; ?>
								                            <?php if (!empty($importLocation->id_cqp_office)): ?>
								                                <span class="badge bg-cqp"><?= $importLocation->id_cqp_office ?></span><br>
								                            <?php endif; ?>
								                        </td>
								                        <td class="p5"><?= $importLocation->address ?></td>
								                        <td class="p5"><?= $importLocation->city . ', ' . $importLocation->state ?></td>
								                        <td class="p5"><?= $importLocation->zip ?></td>
								                        <td class="actions p5">
								                            <?php if (!empty($importLocation->location->is_junk)): ?>
								                                <div class="btn-group-sm btn-group-vertical">
								                                    <?= $this->Html->link(
								                                        'Not Junk',
								                                        ['prefix' => 'Admin', 'controller' => 'imports', 'action' => 'location_not_junk', $importLocation->location_id],
								                                        ['escape' => false, 'class' => 'btn btn-default btn-xs bi bi-slash-circle'],
								                                        'Are you sure you want to remove this location from junk?'
								                                    ) ?>
								                                </div>
								                            <?php elseif (!empty($importLocation->location_id)): ?>
								                                <div class="btn-group-sm btn-group-vertical">
								                                    <a href="/admin/imports/location_review/<?= $importLocation->location_id ?>/<?= $importLocation->id ?>" class="btn btn-default btn-xs bi bi-eye-fill"> Review</a>                            
								                                    <a href="/admin/imports/location_unlink/<?= $importLocation->id ?>" class="btn btn-default btn-xs js-unlink bi bi-x-circle"> Unlink</a>
								                                    <?= $this->Html->link(
								                                        ' Junk',
								                                        ['prefix' => 'Admin', 'controller' => 'imports', 'action' => 'location_add_junk', $importLocation->id],
								                                        ['escape' => false, 'class' => 'btn btn-default btn-xs bi bi-slash-circle'],
								                                        'Are you sure you want to mark this location as junk?'
								                                    ) ?>
								                                </div>
								                            <?php else: ?>
								                                <div class="btn-group-sm btn-group-vertical">
								                                    <a href="/admin/imports/location_add/<?= $importLocation->id ?>" class="btn btn-default btn-xs bi bi-plus-circle-fill"> Add</a>
								                                    <a href="/admin/imports/location_link/<?= $importLocation->id ?>" class="btn btn-default btn-xs bi bi-link-45deg"> Link</a>
								                                    <?= $this->Html->link(
								                                        ' Junk',
								                                        ['prefix' => 'Admin', 'controller' => 'imports', 'action' => 'location_add_junk', $importLocation->id],
								                                        ['escape' => false, 'class' => 'btn btn-default btn-xs bi bi-slash-circle'],
								                                        'Are you sure you want to mark this location as junk?'
								                                    ) ?>
								                                </div>
								                            <?php endif; ?>
								                        </td>
								                    </tr>
								                <?php endforeach; ?>
								            </tbody>
								        </table>
								    </div>
								    <div class="paginator">
								        <ul class="pagination">
								            <?= $this->Paginator->first('<< ' . __('first')) ?>
								            <?= $this->Paginator->prev('< ' . __('previous')) ?>
								            <?= $this->Paginator->numbers() ?>
								            <?= $this->Paginator->next(__('next') . ' >') ?>
								            <?= $this->Paginator->last(__('last') . ' >>') ?>
								        </ul>
								        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
								    </div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
