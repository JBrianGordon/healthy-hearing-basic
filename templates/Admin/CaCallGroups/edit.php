<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup $caCallGroup
 */
use \App\Model\Entity\CaCallGroup;
use \App\Model\Entity\CaCall;
use Cake\Routing\Router;
echo $this->element('ca_calls/ca_call_js_variables');
$this->Html->script('dist/ca_call_edit.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Ca Call Groups Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Delete', ['action' => 'delete', $caCallGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id), 'class' => 'btn btn-danger bi bi-trash']) ?>
                <?= $this->Html->link(' Inbound Call', ['controller' => 'CaCalls', 'action' => 'edit'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Calls from clinic', ['controller' => 'CaCalls', 'action' => 'clinic_lookup'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Quick Pick', ['controller' => 'CaCalls', 'action' => 'quick_pick'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Outbound Calls', ['action' => 'outbound'], ['class' => 'btn btn-default bi bi-megaphone-fill']) ?>
                <?= $this->Html->link(' Calls', ['controller' => 'CaCalls', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Call Groups', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Edit Call Group</h2>
                <?= $this->Form->create($caCallGroup, ['idPrefix'=>'ca-call-group']) ?>
                    <?= $this->Form->hidden('id', ['id' => true]) ?>
                    <?= $this->Form->hidden('location_id', ['id' => true]) ?>
                    <?= $this->Form->hidden('is_prospect_override', ['id' => true]) ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                            <tr>
                                <th style="width:25%" class="tar">Group ID</th>
                                <td><?= $caCallGroup->id ?></td>
                            </tr>
                            <tr>
                                <th class="tar">XML File Id</th>
                                <td><?= $caCallGroup->id_xml_file ?></td>
                            </tr>
                            <tr>
                                <th class="tar">Status</th>
                                <td><?= isset($caCallGroup->status) ? CaCallGroup::$statuses[$caCallGroup->status] : '' ?></td>
                            </tr>
                            <tr>
                                <th class="tar">Clinic</th>
                                <td>
                                    <?php if ($caCallGroup->has('location')): ?>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <?= $this->Html->link($caCallGroup->location->title, $caCallGroup->location->hh_url) ?><br>
                                                <?= $caCallGroup->location->address ?> <?= $caCallGroup->location->address_2 ?><br>
                                                <?= $caCallGroup->location->city ?>, <?= $caCallGroup->location->state ?> <?= $caCallGroup->location->zip ?><br>
                                                <?= $caCallGroup->location->phone ?><br>
                                                <?php if (!empty($caCallGroup->location->optional_message)): ?>
                                                    <span class="locationMessage">Landmarks: <?= $caCallGroup->location->optional_message ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($caCallGroup->location->landmarks)): ?>
                                                    <strong>Landmarks: <?= $caCallGroup->location->landmarks ?></strong>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="locationHours small"></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="tar">Calls</th>
                                <td>
                                    <table class="table table-bordered table-condensed">
                                        <tbody>
                                            <tr>
                                                <th>ID</th>
                                                <th>Call time</th>
                                                <th>Duration</th>
                                                <th>Agent</th>
                                                <th>Call type</th>
                                            </tr>
                                            <?php foreach ($caCallGroup->ca_calls as $caCalls) : ?>
                                                <tr>
                                                    <td><?= $caCalls->id ?></td>
                                                    <td>
                                                        <?php $startTimeEastern = $caCalls->start_time->setTimezone('America/New_York'); ?>
                                                        <?php echo $startTimeEastern->format('m/d/Y'); ?><br>
                                                        <?php echo $startTimeEastern->format('g:i a T'); ?>
                                                    </td>
                                                    <td><?= gmdate('H:i:s', $caCalls->duration) ?></td>
                                                    <td><?= $this->App->getUserName($caCalls->user_id) ?></td>
                                                    <td><?= CaCall::$callTypes[$caCalls->call_type] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th class="tar">Notes</th>
                                <td>
                                    <div class="notes">
                                        <?php foreach ($caCallGroup->ca_call_group_notes as $caCallGroupNotes) : ?>
                                            <div class="single_note">
                                                <table cellpadding="0" cellspacing="0" class="mb0 border-0">
                                                    <tbody>             
                                                        <tr>
                                                            <td class="note_who p0 border-0"><?= $this->App->getUserName($caCallGroupNotes->user_id) ?></td>
                                                            <td class="status p0 border-0"><?= empty($caCallGroupNotes->status) ? '' : CaCallGroup::$statuses[$caCallGroupNotes->status] ?></td>
                                                            <td class="when p0 border-0"><?= dateTimeCentralToEastern($caCallGroupNotes->created) ?></td>
                                                            <td class="delete p0 border-0">
                                                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ca_call_group_notes', 'action' => 'delete', $caCallGroupNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id), 'class' => 'btn btn-danger btn-xs']) ?> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="body p0 border-0"><?= $caCallGroupNotes->body ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <fieldset>
                        <?php
                        echo $this->Form->control('refused_name', [
                            'container' => ['class' => 'offset-md-3']
                        ]);
                        echo $this->Form->control('caller_first_name');
                        echo $this->Form->control('caller_last_name');
                        echo $this->Form->control('caller_phone');
                        echo $this->Form->control('email');
                        echo $this->Form->control('is_patient', [
                            'label' => 'Self',
                            'container' => ['class' => 'offset-md-3']
                        ]);
                        ?>
                        <div class="patient-data" style="display:none;">
                            <?php echo $this->Form->control('patient_first_name'); ?>
                            <?php echo $this->Form->control('patient_last_name'); ?>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Topic</label>
                            <div class="col-md-9">
                                <div class="row well p5 mb0">
                                    <div class="col-md-6">
                                        <?php
                                        foreach (CaCallGroup::$col1Topics as $topicKey => $label) {
                                            echo $this->Form->control($topicKey, [
                                                'label' => [
                                                    'text'=>'<span class="topic-label">'.$label.'</span>',
                                                    'style' => 'text-align:left;'
                                                ],
                                                'escape' => false,
                                            ]);
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        foreach (CaCallGroup::$col2Topics as $topicKey => $label) {
                                            echo $this->Form->control($topicKey, [
                                                'label' => [
                                                    'text'=>'<span class="topic-label">'.$label.'</span>',
                                                    'style' => 'text-align:left;'
                                                ],
                                                'escape' => false,
                                            ]);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $this->Form->setTemplates([
                                // Add an offset to checkbox containers
                                'checkboxContainer' => '<div{{containerAttrs}} class="offset-md-3 {{containerClass}}form-group form-check{{variant}} {{type}}{{required}}">{{content}}{{help}}</div>',
                            ]);
                            echo $this->Form->control('prospect', [
                                'type' => 'select',
                                'options' => CaCallGroup::$prospectOptions,
                                'empty' => false
                            ]);
                        ?>
                        <div class="prospectTopic" style="display:none;">
                            <div class="nonDirectBook" style="display:none;">
                                <?php echo $this->Form->control('front_desk_name'); ?>
                            </div>
                            <?php
                            echo $this->Form->control('score', [
                                'type' => 'select',
                                'options' => CaCallGroup::$scores,
                                'required' => true
                            ]);
                            ?>
                        </div>
                        <div class="appt_date" style="display:none;">
                            <?php echo $this->Form->control('appt_date', ['empty' => true]); ?>
                        </div>
                        <div class="scheduled_call_date" style="display:none;">
                            <?php echo $this->Form->control('scheduled_call_date', ['empty' => true]); ?>
                        </div>
                        <?php
                            echo $this->Form->control('status', [
                                'type' => 'select',
                                'options' => CaCallGroup::$statuses,
                                'required' => true
                            ]);
                            $noteCount = count($caCallGroup->ca_call_group_notes);
                            echo $this->Form->control("ca_call_group_notes.$noteCount.body", [
                                'label' => 'Add a note',
                                'rows' => 3,
                                'required' => false,
                            ]);
                            echo $this->Form->control('is_review_needed', array(
                                'label' => 'Needs supervisor review',
                            ));
                        ?>
                    </fieldset>
                    <div class="tar">
                        <?= $this->Form->submit('Save Call Group', ['id' => 'submitBtn']) ?>
                    </div>
                <?= $this->Form->end() ?>
                <script type="text/javascript">
                    // Global javascript variables
                    var isCallDateSet = <?php echo json_encode(!empty($caCallGroup->scheduled_call_date)); ?>;
                    window.IS_CALL_GROUP_EDIT_PAGE = true;
                    window.IS_CLINIC_LOOKUP_PAGE = false;
                </script>
            </div>
        </div>
    </section>
</div>