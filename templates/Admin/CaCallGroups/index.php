<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup[]|\Cake\Collection\CollectionInterface $caCallGroups
 */
use App\Model\Entity\CaCallGroup;
use Cake\Routing\Router;

$additionalBlacklist = [];
$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
$topics = array_merge(CaCallGroup::$col1Topics, CaCallGroup::$col2Topics);
// Fields to ignore
$ignoreFields = ['lock_time', 'id_locked_by_user', 'outbound_priority', 'id_xml_file'];
$ignoreFields = array_merge($ignoreFields, array_keys($topics));
// Advanced search details
$advancedSearchFields = [];
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
            case 'score':
                $type = 'selectMultiple';
                $options = CaCallGroup::$scores;
                break;
            case 'status':
                $type = 'selectMultiple';
                $options = CaCallGroup::$statuses;
                break;
            case 'prospect':
                $type = 'select';
                $options = CaCallGroup::$prospectOptions;
                $empty = '(select one)';
                break;
            case 'question_visit_clinic':
                $type = 'select';
                $options = CaCallGroup::$questionVisitClinicAnswers;
                $empty = '(select one)';
                break;
            case 'question_brand':
                $type = 'select';
                $options = CaCallGroup::$questionBrandAnswers;
                $empty = '(select one)';
                break;
            case 'question_purchase':
                $type = 'select';
                $options = CaCallGroup::$questionPurchaseAnswers;
                $empty = '(select one)';
                break;
            case 'question_what_for':
                $type = 'select';
                $options = CaCallGroup::$questionWhatForAnswers;
                $empty = '(select one)';
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
// Add 'Topics' as a group of checkboxes
$topicFields = [];
foreach ($topics as $field => $label) {
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    $topicFields[] = [
        'field' => $field,
        'type' => 'checkbox',
        'label' => $label,
        'options' => false,
        'empty' => false,
        'value' => $value
    ];
}
$advancedSearchFields[] = [
    'checkboxGroupName' => 'Topics',
    'checkboxFields' => $topicFields
];

$this->Html->script('dist/ca_call_index.min', ['block' => true]);
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
						<div class="panel-heading">Ca Call Groups Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->element('ca_calls/action_bar', ['spamCount' => $spamCount]) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2>Call Groups</h2>
								<div class="caCallGroups index content">
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields, 'additionalBlacklist' => $additionalBlacklist]) ?>
								    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
								    <div class="table-responsive">
								        <table class="table table-striped table-bordered table-sm">
								            <thead>
								                <tr>
								                    <th class="p5"><?= $this->Paginator->sort('id', 'Group ID') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('location_id', 'Clinic') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('caller_last_name', 'Caller name') ?>/<br><?= $this->Paginator->sort('patient_last_name', 'Patient name') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('created', 'Initial call time') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('score') ?></th>
								                    <th class="p5"><?= $this->Paginator->sort('prospect') ?>/<br><?= $this->Paginator->sort('status') ?></th>
								                    <th class="p5">Flags: <?= $this->Paginator->sort('is_review_needed', 'RN') ?>/<?= $this->Paginator->sort('is_prospect_override', 'PO') ?>/<br>
								                        <?= $this->Paginator->sort('is_spam', 'Spam') ?></th>
								                    <th class="actions p5"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($caCallGroups as $caCallGroup): ?>
								                    <tr>
								                        <td class="p5"><?= $caCallGroup->id ?></td>
								                        <td class="p5">
								                            <?php if (!empty($caCallGroup->location)): ?>
								                                <?= $this->Html->link($caCallGroup->location->title, ['controller' => 'Admin/Locations', 'action' => 'edit', 'prefix' => false, $caCallGroup->location_id]) ?><br>
								                                <?= $caCallGroup->location->city ?>, <?= $caCallGroup->location->state ?><br>
								                                <?= $this->Html->link('All Call Groups', ['controller' => 'CaCallGroups', 'action' => 'index', '?' => ['location_id' => $caCallGroup->location_id]], ['class' => 'btn btn-default btn-xs']) ?>
								                            <?php endif; ?>
								                        </td>
								                        <td class="p5">
								                            <?= h($caCallGroup->caller_first_name) ?> <?= h($caCallGroup->caller_last_name) ?><br>
								                            <?= h($caCallGroup->patient_first_name) ?> <?= h($caCallGroup->patient_last_name) ?>
								                        </td>
								                        <td class="p5">
								                            <?php if (isset($caCallGroup->ca_calls[0])): ?>
								                                <?php echo date("m/d/Y", strtotime($caCallGroup->ca_calls[0]['start_time'])); ?><br>
								                                <?php echo date("g:i a ", strtotime($caCallGroup->ca_calls[0]['start_time'])).getEasternTimezone(); ?>
								                            <?php else: ?>
								                                <span class="badge bg-danger">No calls</span>
								                            <?php endif; ?>
								                        </td>
								                        <td class="p5">
								                            <?php if (!empty($caCallGroup->score)): ?>
								                                <?= CaCallGroup::$scores[$caCallGroup->score] ?>
								                            <?php endif; ?>
								                        </td>
								                        <td class="p5">
									                        <?php if (!empty($caCallGroup->prospect)): ?>
									                            <span class="label label-default"><?= $caCallGroup->prospect ?></span><br>
									                        <?php endif; ?>
									                        <?= CaCallGroup::$statuses[$caCallGroup->status] ?></td>
								                        <td class="p5">
								                            <?php if ($caCallGroup->is_review_needed): ?>
								                                <span class="badge bg-danger">Review Needed</span>
								                            <?php endif; ?>
								                            <?php if ($caCallGroup->is_prospect_override): ?>
								                                <span class="badge bg-warning">Prospect Override</span>
								                            <?php endif; ?>
								                            <?php if ($caCallGroup->is_spam): ?>
								                                <span class="badge bg-danger">Spam</span>
								                            <?php endif; ?>
								                        </td>
								                        <td class="actions p5">
								                            <div class="btn-group-vertical btn-group-sm">
								                                <?= $this->Html->link(__(' View'), ['action' => 'view', $caCallGroup->id], ['class' => 'btn btn-default bi bi-eye-fill']) ?>
								                                <?= $this->Html->link(__(' Edit'), ['action' => 'edit', $caCallGroup->id], ['class' => 'btn btn-default bi bi-pencil-fill']) ?>
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
