<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCall[]|\Cake\Collection\CollectionInterface $caCalls
 */
use App\Model\Entity\CaCall;
use App\Model\Entity\CaCallGroup;
use Cake\Routing\Router;

$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = [];
// Add additional fields
$fields['CaCallGroups.status'] = 'string';
$fields['CaCallGroups.score'] = 'string';
$fields['CaCallGroups.caller_first_name'] = 'string';
$fields['CaCallGroups.caller_last'] = 'string';
//$fields['CaCallGroups.score'] = 'string';
//$fields['CaCallGroups.score'] = 'string';
$additionalBlacklist = ['CaCallGroups'];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
        if (in_array($type, ['date', 'datetime'])) {
            $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
            $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
        }
        switch ($field) {
            case 'call_type':
                $type = 'selectMultiple';
                $options = CaCall::$callTypes;
                break;
            case 'CaCallGroups.status':
                $label = 'Status';
                $type = 'selectMultiple';
                $options = CaCallGroup::$statuses;
                break;
            case 'CaCallGroups.score':
                $label = 'Score';
                $type = 'selectMultiple';
                $options = CaCallGroup::$scores;
                break;
            case 'user_id':
                $label = 'Agent';
                $type = 'selectMultiple';
                $options = $agents;
                break;
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
}

$this->Html->script('dist/ca_call_index.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Ca Calls Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->element('ca_calls/action_bar') ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2>Calls</h2>
				<div class="caCalls index content">
				    <?= $this->element('pagination') ?>
				    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields, 'additionalBlacklist' => $additionalBlacklist]) ?>
				    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
				    <?= $this->Form->input('hiddenCount', ['id' => 'hiddenCount', 'type' => 'hidden', 'value' => $count]) ?>
				    <?= $this->Form->input('hiddenExport', ['id' => 'hiddenExport', 'type' => 'hidden', 'value' => $exportUrl]) ?>
				    <div class="table-responsive mt30">
				        <table class="table table-striped table-bordered table-sm">
				            <thead>
				                <tr>
				                    <th class="p5" nowrap><?= $this->Paginator->sort('id', 'Call ID') ?><br>
				                    <?= $this->Paginator->sort('ca_call_group_id', 'Group ID') ?></th>
				                    <th class="p5">Clinic</th>
				                    <th class="p5"><?= $this->Paginator->sort('user_id', 'Agent') ?></th>
				                    <th class="p5" nowrap>Caller Name/<br>Patient Name</th>
				                    <th class="p5"><?= $this->Paginator->sort('start_time', 'Call Time') ?>/<br>
				                        <?= $this->Paginator->sort('duration') ?></th>
				                    <th class="p5"><?= $this->Paginator->sort('call_type') ?></th>
				                    <th class="p5">Status</th>
				                    <th class="p5">Flags:<br>RN/PO</th>
				                    <th class="actions p5"><?= __('Actions') ?></th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php foreach ($caCalls as $caCall): ?>
				                    <tr>
				                        <td class="p5"><?= $caCall->id ?><br>
				                            <?= $caCall->has('ca_call_group') ? $this->Html->link($caCall->ca_call_group->id, ['controller' => 'CaCallGroups', 'action' => 'view', $caCall->ca_call_group->id]) : '' ?></td>
				                        <td class="p5">
				                            <?php if (!empty($caCall->ca_call_group->location)): ?>
				                                <!-- TODO: hh_url -->
				                                <?= $this->Html->link($caCall->ca_call_group->location->title, ['controller' => 'Locations', 'action' => 'view', 'prefix' => false, $caCall->ca_call_group->location_id]) ?><br>
				                                <?= $caCall->ca_call_group->location->city ?>, <?= $caCall->ca_call_group->location->state ?><br>
				                                <?= $this->Html->link('All Call Groups', ['controller' => 'CaCallGroups', 'action' => 'index', '?' => ['location_id' => $caCall->ca_call_group->location_id]], ['class' => 'btn btn-default btn-xs']) ?>
				                            <?php endif; ?>
				                        </td>
				                        <td class="p5"><?= $caCall->has('user') ? $caCall->user->username : '' ?></td>
				                        <td class="p5">
				                            <?= $caCall->ca_call_group->caller_first_name.' '.$caCall->ca_call_group->caller_last_name ?><br>
				                            <?= $caCall->ca_call_group->patient_first_name.' '.$caCall->ca_call_group->patient_last_name ?>
				                        </td>
				                        <td class="p5" nowrap>
				                            <?= date("m/d/Y", strtotime($caCall->start_time)); ?><br>
				                            <?= date("g:i a ", strtotime($caCall->start_time)).getEasternTimezone(); ?><br>
				                            <?= gmdate("H:i:s", $caCall->duration) ?>
				                        </td>
				                        <td class="p5"><?= isset($caCall->call_type) ? CaCall::$callTypes[$caCall->call_type] : '' ?></td>
				                        <td class="p5"><?= isset($caCall->ca_call_group->status) ? CaCallGroup::$statuses[$caCall->ca_call_group->status] : '' ?></td>
				                        <td class="p5">
				                            <?php if ($caCall->ca_call_group->is_review_needed): ?>
				                                <span class="badge bg-danger">Review Needed</span>
				                            <?php endif; ?>
				                            <?php if ($caCall->ca_call_group->is_prospect_override): ?>
				                                <span class="badge bg-warning">Prospect Override</span>
				                            <?php endif; ?>
				                        </td>
				                        <td class="actions p5" nowrap>
				                            <div class="btn-group-vertical btn-group-xs">
				                                <?= $this->Html->link('View Group', ['controller' => 'CaCallGroups', 'action' => 'view', $caCall->ca_call_group->id], ['class' => 'btn btn-default']) ?>
				                                <?= $this->Html->link('Edit Group', ['controller' => 'CaCallGroups', 'action' => 'edit', $caCall->ca_call_group->id], ['class' => 'btn btn-default']) ?>
				                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $caCall->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $caCall->id)]) ?>
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