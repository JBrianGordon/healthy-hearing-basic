<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */

 use App\Model\Entity\CsCall;

$queryParams = $this->request->getQueryParams();
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = ['ad_source', 'result', 'duration', 'call_type', 'call_status', 'recording_url', 'tracking_number', 'caller_phone', 'clinic_phone'];
$fields = array_diff_key($fields, array_flip($ignoreFields));
 foreach ($fields as $field => $type) {
     $label = '';
     if ($field == 'start_time') {
        $label = 'Call date';
     }
     $options = false;
     $empty = false;
     $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
     $placeholder = null;
     if (in_array($type, ['date', 'datetime'])) {
        $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
        $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
    }
    switch ($field) {
        case 'caller_firstname':
            $label = 'Caller first name';
            break;
        case 'caller_lastname':
            $label = 'Caller last name';
            break;
        case 'leadscore':
            $type = 'select';
            $options = [
                null => '(select one)', 
                'Appointment Set' => 'Appointment Set', 
                'Missed Opportunity' => 'Missed Opportunity'
            ];
            break;
        case 'prospect':
            $type = 'select';
            $options = [
                null => '(select one)', 
                'prospect' => 'Prospect', 
                'non_prospect' => 'Non-prospect',
                'prospect_unknown' => 'Unknown'
            ];
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

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Cs Calls Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <!--*** TODO: export function will need to be built out in controller ***-->
                <?= $this->Form->button(' Export', ['type' => 'button', 'id' => 'exportBtn', 'class' => 'btn btn-default bi bi-download', 'escapeTitle' => false]) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Call Tracking Calls</h2>
                <!--*** TODO: add Cs Call search, advanced search and save search ***-->
                <div class="csCalls index content">
                    <?= $this->element('pagination') ?>
				    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
                    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('id') ?><br><?= $this->Paginator->sort('call_id', ['label' => 'CS Call ID']) ?></th>
                                    <!--*** TODO: pull in clinic names instead of clinic id's ***-->
                                    <th><?= $this->Paginator->sort('location_id', ['text' => 'Clinic']) ?></th>
                                    <th><?= $this->Paginator->sort('caller_lastname', ['text' => 'Caller Name']) ?></th>
                                    <th style="min-width:150px"><?= $this->Paginator->sort('start_time') ?>/<br><?= $this->Paginator->sort('duration') ?></th>
                                    <th><?= $this->Paginator->sort('prospect') ?></th>
                                    <th><?= $this->Paginator->sort('leadscore') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($csCalls as $csCall): ?>
                                <tr>
                                    <td><?= $csCall->id ?><br><?= $csCall->call_id ?></td>
                                    <td><?= isset($csCall->location) ? $this->Html->link($csCall->location->title, $csCall->location->hh_url) . '<br>' . $csCall->location->city . ', ' . $csCall->location->state . '<br><a href="/admin/cs-calls/index?location_id=' . $csCall->location->id . '" class="btn btn-default btn-xs">All Calls</a>' : '' ?></td>
                                    <td><?= h($csCall->caller_firstname) ?> <?= h($csCall->caller_lastname) ?></td>
                                    <td><?= h($csCall->start_time) ?><br><?= gmdate("H:i:s", $csCall->duration) ?></td>
                                    <td><?= ucwords(str_replace('prospect-', '', str_replace('_', '-', strtolower(h($csCall->prospect))))) ?></td>
                                    <td><?= h($csCall->leadscore) ?></td>
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