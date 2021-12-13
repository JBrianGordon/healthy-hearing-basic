<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup $caCallGroup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ca Call Group'), ['action' => 'edit', $caCallGroup->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ca Call Group'), ['action' => 'delete', $caCallGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Ca Call Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ca Call Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="caCallGroups view content">
            <h3><?= h($caCallGroup->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $caCallGroup->has('location') ? $this->Html->link($caCallGroup->location->title, ['controller' => 'Locations', 'action' => 'view', $caCallGroup->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Caller Phone') ?></th>
                    <td><?= h($caCallGroup->caller_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caller First Name') ?></th>
                    <td><?= h($caCallGroup->caller_first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caller Last Name') ?></th>
                    <td><?= h($caCallGroup->caller_last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient First Name') ?></th>
                    <td><?= h($caCallGroup->patient_first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Last Name') ?></th>
                    <td><?= h($caCallGroup->patient_last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($caCallGroup->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Prospect') ?></th>
                    <td><?= h($caCallGroup->prospect) ?></td>
                </tr>
                <tr>
                    <th><?= __('Front Desk Name') ?></th>
                    <td><?= h($caCallGroup->front_desk_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Score') ?></th>
                    <td><?= h($caCallGroup->score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($caCallGroup->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Question Visit Clinic') ?></th>
                    <td><?= h($caCallGroup->question_visit_clinic) ?></td>
                </tr>
                <tr>
                    <th><?= __('Question What For') ?></th>
                    <td><?= h($caCallGroup->question_what_for) ?></td>
                </tr>
                <tr>
                    <th><?= __('Question Purchase') ?></th>
                    <td><?= h($caCallGroup->question_purchase) ?></td>
                </tr>
                <tr>
                    <th><?= __('Question Brand') ?></th>
                    <td><?= h($caCallGroup->question_brand) ?></td>
                </tr>
                <tr>
                    <th><?= __('Question Brand Other') ?></th>
                    <td><?= h($caCallGroup->question_brand_other) ?></td>
                </tr>
                <tr>
                    <th><?= __('Traffic Medium') ?></th>
                    <td><?= h($caCallGroup->traffic_medium) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Xml File') ?></th>
                    <td><?= h($caCallGroup->id_xml_file) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($caCallGroup->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ca Call Count') ?></th>
                    <td><?= $this->Number->format($caCallGroup->ca_call_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinic Followup Count') ?></th>
                    <td><?= $this->Number->format($caCallGroup->clinic_followup_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Followup Count') ?></th>
                    <td><?= $this->Number->format($caCallGroup->patient_followup_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinic Outbound Count') ?></th>
                    <td><?= $this->Number->format($caCallGroup->clinic_outbound_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Outbound Count') ?></th>
                    <td><?= $this->Number->format($caCallGroup->patient_outbound_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vm Outbound Count') ?></th>
                    <td><?= $this->Number->format($caCallGroup->vm_outbound_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Locked By User') ?></th>
                    <td><?= $this->Number->format($caCallGroup->id_locked_by_user) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outbound Priority') ?></th>
                    <td><?= $this->Number->format($caCallGroup->outbound_priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Appt Date') ?></th>
                    <td><?= h($caCallGroup->appt_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scheduled Call Date') ?></th>
                    <td><?= h($caCallGroup->scheduled_call_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final Score Date') ?></th>
                    <td><?= h($caCallGroup->final_score_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lock Time') ?></th>
                    <td><?= h($caCallGroup->lock_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($caCallGroup->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($caCallGroup->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Patient') ?></th>
                    <td><?= $caCallGroup->is_patient ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Refused Name') ?></th>
                    <td><?= $caCallGroup->refused_name ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Wants Appt') ?></th>
                    <td><?= $caCallGroup->topic_wants_appt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Clinic Hours') ?></th>
                    <td><?= $caCallGroup->topic_clinic_hours ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Insurance') ?></th>
                    <td><?= $caCallGroup->topic_insurance ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Clinic Inquiry') ?></th>
                    <td><?= $caCallGroup->topic_clinic_inquiry ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Aid Lost Old') ?></th>
                    <td><?= $caCallGroup->topic_aid_lost_old ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Aid Lost New') ?></th>
                    <td><?= $caCallGroup->topic_aid_lost_new ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Warranty Old') ?></th>
                    <td><?= $caCallGroup->topic_warranty_old ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Warranty New') ?></th>
                    <td><?= $caCallGroup->topic_warranty_new ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Batteries') ?></th>
                    <td><?= $caCallGroup->topic_batteries ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Parts') ?></th>
                    <td><?= $caCallGroup->topic_parts ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Cancel Appt') ?></th>
                    <td><?= $caCallGroup->topic_cancel_appt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Reschedule Appt') ?></th>
                    <td><?= $caCallGroup->topic_reschedule_appt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Appt Followup') ?></th>
                    <td><?= $caCallGroup->topic_appt_followup ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Medical Records') ?></th>
                    <td><?= $caCallGroup->topic_medical_records ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Tinnitus') ?></th>
                    <td><?= $caCallGroup->topic_tinnitus ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Hearing Previously Tested') ?></th>
                    <td><?= $caCallGroup->topic_hearing_previously_tested ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Aids Previously Worn') ?></th>
                    <td><?= $caCallGroup->topic_aids_previously_worn ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Medical Inquiry') ?></th>
                    <td><?= $caCallGroup->topic_medical_inquiry ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Solicitor') ?></th>
                    <td><?= $caCallGroup->topic_solicitor ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Personal Call') ?></th>
                    <td><?= $caCallGroup->topic_personal_call ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Request Fax') ?></th>
                    <td><?= $caCallGroup->topic_request_fax ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Request Name') ?></th>
                    <td><?= $caCallGroup->topic_request_name ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Remove From List') ?></th>
                    <td><?= $caCallGroup->topic_remove_from_list ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Foreign Language') ?></th>
                    <td><?= $caCallGroup->topic_foreign_language ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Other') ?></th>
                    <td><?= $caCallGroup->topic_other ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic Declined') ?></th>
                    <td><?= $caCallGroup->topic_declined ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Wants Hearing Test') ?></th>
                    <td><?= $caCallGroup->wants_hearing_test ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Prospect Override') ?></th>
                    <td><?= $caCallGroup->is_prospect_override ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Bringing Third Party') ?></th>
                    <td><?= $caCallGroup->is_bringing_third_party ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Review Needed') ?></th>
                    <td><?= $caCallGroup->is_review_needed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Locked') ?></th>
                    <td><?= $caCallGroup->is_locked ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Did They Want Help') ?></th>
                    <td><?= $caCallGroup->did_they_want_help ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Appt Request Form') ?></th>
                    <td><?= $caCallGroup->is_appt_request_form ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Spam') ?></th>
                    <td><?= $caCallGroup->is_spam ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Traffic Source') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($caCallGroup->traffic_source)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Ca Call Group Notes') ?></h4>
                <?php if (!empty($caCallGroup->ca_call_group_notes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Ca Call Group Id') ?></th>
                            <th><?= __('Body') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($caCallGroup->ca_call_group_notes as $caCallGroupNotes) : ?>
                        <tr>
                            <td><?= h($caCallGroupNotes->id) ?></td>
                            <td><?= h($caCallGroupNotes->ca_call_group_id) ?></td>
                            <td><?= h($caCallGroupNotes->body) ?></td>
                            <td><?= h($caCallGroupNotes->status) ?></td>
                            <td><?= h($caCallGroupNotes->user_id) ?></td>
                            <td><?= h($caCallGroupNotes->created) ?></td>
                            <td><?= h($caCallGroupNotes->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CaCallGroupNotes', 'action' => 'view', $caCallGroupNotes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CaCallGroupNotes', 'action' => 'edit', $caCallGroupNotes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CaCallGroupNotes', 'action' => 'delete', $caCallGroupNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroupNotes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Ca Calls') ?></h4>
                <?php if (!empty($caCallGroup->ca_calls)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Ca Call Group Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('Duration') ?></th>
                            <th><?= __('Call Type') ?></th>
                            <th><?= __('Recording Url') ?></th>
                            <th><?= __('Recording Duration') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($caCallGroup->ca_calls as $caCalls) : ?>
                        <tr>
                            <td><?= h($caCalls->id) ?></td>
                            <td><?= h($caCalls->ca_call_group_id) ?></td>
                            <td><?= h($caCalls->user_id) ?></td>
                            <td><?= h($caCalls->start_time) ?></td>
                            <td><?= h($caCalls->duration) ?></td>
                            <td><?= h($caCalls->call_type) ?></td>
                            <td><?= h($caCalls->recording_url) ?></td>
                            <td><?= h($caCalls->recording_duration) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CaCalls', 'action' => 'view', $caCalls->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CaCalls', 'action' => 'edit', $caCalls->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CaCalls', 'action' => 'delete', $caCalls->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCalls->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
