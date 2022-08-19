<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCall[]|\Cake\Collection\CollectionInterface $caCalls
 */
use App\Model\Entity\CaCall;
use App\Model\Entity\CaCallGroup;
use Cake\Routing\Router;
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = [];
// Add additional fields
$fields['CaCallGroups.status'] = 'string';
$fields['CaCallGroups.score'] = 'string';
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
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
?>
<div class="caCalls index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->element('ca_calls/action_bar') ?>
        <?= $this->Form->button("<i class='bi bi-download'></i> Export", ['type' => 'button', 'id' => 'exportBtn', 'class' => 'btn btn-default', 'escapeTitle' => false]) ?>
    </div>
    <h3>Calls</h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th nowrap><?= $this->Paginator->sort('id', 'Call ID') ?><br>
                    <?= $this->Paginator->sort('ca_call_group_id', 'Group ID') ?></th>
                    <th>Clinic</th>
                    <th><?= $this->Paginator->sort('user_id', 'Agent') ?></th>
                    <th nowrap>Caller Name<br>Patient Name</th>
                    <th><?= $this->Paginator->sort('start_time', 'Call Time') ?><br>
                        <?= $this->Paginator->sort('duration') ?></th>
                    <th><?= $this->Paginator->sort('call_type') ?></th>
                    <th>Status</th>
                    <th>Flags</th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($caCalls as $caCall): ?>
                    <tr>
                        <td><?= $caCall->id ?><br>
                            <?= $caCall->has('ca_call_group') ? $this->Html->link($caCall->ca_call_group->id, ['controller' => 'CaCallGroups', 'action' => 'view', $caCall->ca_call_group->id]) : '' ?></td>
                        <td>
                            <?php if (!empty($caCall->ca_call_group->location)): ?>
                                <!-- TODO: hh_url -->
                                <?= $this->Html->link($caCall->ca_call_group->location->title, ['controller' => 'Locations', 'action' => 'view', 'prefix' => false, $caCall->ca_call_group->location_id]) ?><br>
                                <?= $caCall->ca_call_group->location->city ?>, <?= $caCall->ca_call_group->location->state ?><br>
                                <?= $this->Html->link('All Call Groups', ['controller' => 'CaCallGroups', 'action' => 'index', '?' => ['location_id' => $caCall->ca_call_group->location_id]], ['class' => 'btn btn-default btn-xs']) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $caCall->has('user') ? $caCall->user->username : '' ?></td>
                        <td>
                            <?= $caCall->ca_call_group->caller_first_name.' '.$caCall->ca_call_group->caller_last_name ?><br>
                            <?= $caCall->ca_call_group->patient_first_name.' '.$caCall->ca_call_group->patient_last_name ?>
                        </td>
                        <td nowrap>
                            <?= date("m/d/Y", strtotime($caCall->start_time)); ?><br>
                            <?= date("g:i a ", strtotime($caCall->start_time)).getEasternTimezone(); ?><br>
                            <?= gmdate("H:i:s", $caCall->duration) ?>
                        </td>
                        <td><?= CaCall::$callTypes[$caCall->call_type] ?></td>
                        <td><?= CaCallGroup::$statuses[$caCall->ca_call_group->status] ?></td>
                        <td>
                            <?php if ($caCall->ca_call_group->is_review_needed): ?>
                                <span class="badge bg-danger">Review Needed</span>
                            <?php endif; ?>
                            <?php if ($caCall->ca_call_group->is_prospect_override): ?>
                                <span class="badge bg-warning">Prospect Override</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions" nowrap>
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
