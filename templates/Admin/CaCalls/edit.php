<?php
use \App\Model\Entity\CaCallGroup;
use \App\Model\Entity\CaCall;
use \App\Model\Entity\Location;
use Cake\Core\Configure;
echo $this->element('ca_calls/ca_call_js_variables');
$this->Html->script('dist/ca_call_edit.min', ['block' => true]);

if (isset($caCall->user_id)) {
    $agentName = $this->App->getUserName($caCall->user_id);
}
$previousCalls = empty($previousCalls) ? array() : $previousCalls;
$status = empty($caCall->ca_call_group->status) ? CaCallGroup::STATUS_NEW : $caCall->ca_call_group->status;
$callType = isset($caCall->call_type) ? $caCall->call_type : '';
$isWrongNumber = ($status == CaCallGroup::STATUS_WRONG_NUMBER) ? true : false;
$caCall = empty($caCall) ? array() : $caCall;
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Ca Call Groups Actions</div>
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
                <h2>New Inbound Call</h2>
                <?= $this->Form->create($caCall, ['id' => 'CaCallForm']) ?>
                    <?php $this->Form->setTemplates([
                        // Add an offset to checkbox containers
                        'checkboxContainer' => '<div{{containerAttrs}} class="offset-md-3 {{containerClass}}form-group form-check{{variant}} {{type}}{{required}}">{{content}}{{help}}</div>',
                    ]); ?>
                    <?php
                    echo $this->Form->hidden('ca_call_group_id', ['id'=>'ca-call-ca-call-group-id']);
                    echo $this->Form->hidden('start_time', ['id'=>true]);
                    echo $this->Form->hidden('call_type', ['id'=>true]);
                    echo $this->Form->hidden('user_id', ['id'=>true]);
                    echo $this->Form->hidden('ca_call_group.id', ['id'=>true]);
                    echo $this->Form->hidden('ca_call_group.location_id', ['id'=>true]);
                    echo $this->Form->hidden('ca_call_group.is_prospect_override', ['id'=>true]);
                    echo $this->Form->hidden('ca_call_group.status', ['id'=>true]);
                    echo $this->Form->hidden('ca_call_group.direct_book_type', ['id'=>true, 'value'=>Location::DIRECT_BOOK_NONE]);
                    echo $this->Form->hidden('ca_call_group.id_xml_file', ['id'=>true]);
                    echo $this->Form->hidden('ca_call_group.is_spam', ['id'=>true]);
                    ?>
                    <table class="table table-striped table-bordered table-condensed">
                        <tr><th class="tar" style="width: 25%">Group ID</th>
                            <td>
                                <span class="callGroupId"></span>
                            </td>
                        </tr>
                        <tr><th class="tar">Status</th>
                            <td>
                                <span class="status"><?= CaCallGroup::$statuses[$status] ?></span>
                            </td>
                        </tr>
                        <tr><th class="tar">CallType</th>
                            <td>
                                <?= empty($callType) ? '' : CaCall::$callTypes[$callType] ?>
                            </td>
                        </tr>
                        <?php if (isset($caCall->start_time)): ?>
                            <tr><th class="tar">Start Time</th>
                                <td>
                                    <?= dateTimeEastern($caCall->start_time) ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($caCall->duration)): ?>
                            <tr><th class="tar">Duration</th>
                                <td>
                                    <?= gmdate('H:i:s', $caCall->duration) ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($agentName)): ?>
                            <tr><th class="tar">Agent</th>
                                <td>
                                    <?= $agentName ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr><th class="tar">Clinic</th>
                            <td id="clinic-data">
                                <div class="row">
                                    <div class="col-md-9">
                                        <span class="locationLink"></span><br>
                                        <span class="locationAddress"></span><br>
                                        <span class="locationPhone"></span><br>
                                        <span class="locationMessage"></span><br>
                                        <strong><span class="locationLandmarks"></span></strong>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="locationHours small"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="form_fields">
                        <div class="init_have_location" style="display:none;">
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="well blue-well">
                                        Thank you for calling Healthy Hearing. <?php if ($user != null) : ?>This is <?= $user['first_name'] ?> and<?php endif; ?> I'm here to help you get connected with <strong><span class="locationTitle"></span></strong>. Before we get started, may I please have your first name?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="init_no_location" style="display:none;">
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="well blue-well">
                                        Hello, this is Healthy Hearing and my name is <?= $user['first_name'] ?>. This call is being recorded for quality assurance. Can you tell me the name of the clinic you're trying to reach so I can get you connected?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->control('is_wrong_number', [
                            'type' => 'checkbox',
                            'label' => 'Wrong number?',
                            'default' => $isWrongNumber
                        ]) ?>
                        <div class="init_no_location" style="display:none;">
                            <div class="valid_number">
                                <?= $this->Form->control('location_search', [
                                    'label' => 'Clinic search',
                                    'required' => true,
                                ]) ?>
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="well blue-well">
                                            Great! Now may I please have your first name?
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="valid_number">
                            <?= $this->element('ca_calls/inbound_call_script', ['showScript'=>true, 'noteCount'=>0]) ?>
                        </div>
                    </div>
                    <div class="form-actions tar">
                        <input type="button" tabindex="1" value="Call disconnected / incomplete" class="btn btn-lg btn-default" id="disconnectedBtn">
                        <input type="submit" tabindex="1" value="Save Call" class="btn btn-primary btn-lg" id="submitBtn">
                    </div>
                <?= $this->Form->end() ?>
                <?php $this->append('bs-modals'); ?>
                    <div id="note-required" class="modal fade">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <?= 'Please fill in \'Notes\' field.' ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-hidden="true">Okay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $this->end();?>
                <script type="text/javascript">
                    // Global javascript variables
                    var isCallDateSet = <?php echo json_encode(isset($caCall->ca_call_group->scheduled_call_date)); ?>;
                    window.IS_CALL_GROUP_EDIT_PAGE = false;
                    window.IS_CLINIC_LOOKUP_PAGE = false;
                </script>
            </div>
        </div>
    </section>
</div>