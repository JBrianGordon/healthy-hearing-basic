<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup[]|\Cake\Collection\CollectionInterface $caCallGroups
 */
use App\Model\Entity\CaCallGroup;
use Cake\Routing\Router;
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
$topics = array_merge(CaCallGroup::$col1Topics, CaCallGroup::$col2Topics);
// Fields to ignore
$ignoreFields = array_keys($topics);
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
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
?>
<div class="caCallGroups index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->element('ca_calls/action_bar', ['spamCount' => $spamCount]) ?>
        <?= $this->Form->button("<i class='bi bi-download'></i> Export", ['type' => 'button', 'id' => 'exportBtn', 'class' => 'btn btn-default', 'escapeTitle' => false]) ?>
    </div>
    <h3>Call Groups</h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Group ID') ?></th>
                    <th><?= $this->Paginator->sort('location_id', 'Clinic') ?></th>
                    <th><?= $this->Paginator->sort('caller_phone') ?></th>
                    <th><?= $this->Paginator->sort('caller_last_name', 'Caller name') ?><br><?= $this->Paginator->sort('patient_last_name', 'Patient name') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Initial call time') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('prospect') ?><br><?= $this->Paginator->sort('status') ?></th>
                    <th>Flags: <?= $this->Paginator->sort('is_review_needed', 'RN') ?>/<?= $this->Paginator->sort('is_prospect_override', 'PO') ?>/<br>
                        <?= $this->Paginator->sort('is_spam', 'Spam') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($caCallGroups as $caCallGroup): ?>
                    <tr>
                        <td><?= $caCallGroup->id ?></td>
                        <td>
                            <?php if (!empty($caCallGroup->location)): ?>
                                <!-- TODO: hh_url -->
                                <?= $this->Html->link($caCallGroup->location->title, ['controller' => 'Locations', 'action' => 'view', 'prefix' => false, $caCallGroup->location_id]) ?><br>
                                <?= $caCallGroup->location->city ?>, <?= $caCallGroup->location->state ?><br>
                                <?= $this->Html->link('All Call Groups', ['controller' => 'CaCallGroups', 'action' => 'index', '?' => ['location_id' => $caCallGroup->location_id]], ['class' => 'btn btn-default btn-xs']) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= h($caCallGroup->caller_phone) ?></td>
                        <td>
                            <?= h($caCallGroup->caller_first_name) ?> <?= h($caCallGroup->caller_last_name) ?><br>
                            <?= h($caCallGroup->patient_first_name) ?> <?= h($caCallGroup->patient_last_name) ?>
                        </td>
                        <td>
                            <?php if (isset($caCallGroup->ca_calls[0])): ?>
                                <?php echo date("m/d/Y", strtotime($caCallGroup->ca_calls[0]['start_time'])); ?><br>
                                <?php echo date("g:i a ", strtotime($caCallGroup->ca_calls[0]['start_time'])).getEasternTimezone(); ?>
                            <?php else: ?>
                                <span class="badge bg-danger">No calls</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($caCallGroup->score)): ?>
                                <?= CaCallGroup::$scores[$caCallGroup->score] ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-info"><?= $caCallGroup->prospect ?></span><br>
                            <?= CaCallGroup::$statuses[$caCallGroup->status] ?></td>
                        <td>
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
                        <td class="actions">
                            <div class="btn-group-vertical btn-group-xs">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $caCallGroup->id], ['class' => 'btn btn-default']) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $caCallGroup->id], ['class' => 'btn btn-default']) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
<?php
// TODO: This should be moved into a js file and simplified with jQuery once we have that working.
echo '<script type="text/javascript">
    function exportBtnClick() {
        var count = '.$count.';
        var readableCount = "'.number_format($count).'";
        var exportUrl = "'.$exportUrl.'";
        if (count < 100000) {
            // Small file. Download immediately.
            if (confirm("Downloading export file with "+readableCount+" entries. This may take up to 30 seconds. Stay on this page until download is complete.")) {
                window.location.replace(exportUrl);
            }
        } else {
            // Large file
            // TODO - Large files take over 30 seconds and page times out. Send to queue when queue is working.
            alert("Export is too large. Please narrow your results to 100,000 or less.");
        }
    }
    document.getElementById("exportBtn").addEventListener("click", exportBtnClick);
</script>';
?>
