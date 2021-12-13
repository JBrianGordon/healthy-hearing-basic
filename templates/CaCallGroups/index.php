<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup[]|\Cake\Collection\CollectionInterface $caCallGroups
 */
?>
<div class="caCallGroups index content">
    <?= $this->Html->link(__('New Ca Call Group'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Ca Call Groups') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('caller_phone') ?></th>
                    <th><?= $this->Paginator->sort('caller_first_name') ?></th>
                    <th><?= $this->Paginator->sort('caller_last_name') ?></th>
                    <th><?= $this->Paginator->sort('is_patient') ?></th>
                    <th><?= $this->Paginator->sort('patient_first_name') ?></th>
                    <th><?= $this->Paginator->sort('patient_last_name') ?></th>
                    <th><?= $this->Paginator->sort('refused_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('topic_wants_appt') ?></th>
                    <th><?= $this->Paginator->sort('topic_clinic_hours') ?></th>
                    <th><?= $this->Paginator->sort('topic_insurance') ?></th>
                    <th><?= $this->Paginator->sort('topic_clinic_inquiry') ?></th>
                    <th><?= $this->Paginator->sort('topic_aid_lost_old') ?></th>
                    <th><?= $this->Paginator->sort('topic_aid_lost_new') ?></th>
                    <th><?= $this->Paginator->sort('topic_warranty_old') ?></th>
                    <th><?= $this->Paginator->sort('topic_warranty_new') ?></th>
                    <th><?= $this->Paginator->sort('topic_batteries') ?></th>
                    <th><?= $this->Paginator->sort('topic_parts') ?></th>
                    <th><?= $this->Paginator->sort('topic_cancel_appt') ?></th>
                    <th><?= $this->Paginator->sort('topic_reschedule_appt') ?></th>
                    <th><?= $this->Paginator->sort('topic_appt_followup') ?></th>
                    <th><?= $this->Paginator->sort('topic_medical_records') ?></th>
                    <th><?= $this->Paginator->sort('topic_tinnitus') ?></th>
                    <th><?= $this->Paginator->sort('topic_hearing_previously_tested') ?></th>
                    <th><?= $this->Paginator->sort('topic_aids_previously_worn') ?></th>
                    <th><?= $this->Paginator->sort('topic_medical_inquiry') ?></th>
                    <th><?= $this->Paginator->sort('topic_solicitor') ?></th>
                    <th><?= $this->Paginator->sort('topic_personal_call') ?></th>
                    <th><?= $this->Paginator->sort('topic_request_fax') ?></th>
                    <th><?= $this->Paginator->sort('topic_request_name') ?></th>
                    <th><?= $this->Paginator->sort('topic_remove_from_list') ?></th>
                    <th><?= $this->Paginator->sort('topic_foreign_language') ?></th>
                    <th><?= $this->Paginator->sort('topic_other') ?></th>
                    <th><?= $this->Paginator->sort('topic_declined') ?></th>
                    <th><?= $this->Paginator->sort('wants_hearing_test') ?></th>
                    <th><?= $this->Paginator->sort('prospect') ?></th>
                    <th><?= $this->Paginator->sort('is_prospect_override') ?></th>
                    <th><?= $this->Paginator->sort('front_desk_name') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('appt_date') ?></th>
                    <th><?= $this->Paginator->sort('scheduled_call_date') ?></th>
                    <th><?= $this->Paginator->sort('final_score_date') ?></th>
                    <th><?= $this->Paginator->sort('is_bringing_third_party') ?></th>
                    <th><?= $this->Paginator->sort('is_review_needed') ?></th>
                    <th><?= $this->Paginator->sort('ca_call_count') ?></th>
                    <th><?= $this->Paginator->sort('clinic_followup_count') ?></th>
                    <th><?= $this->Paginator->sort('patient_followup_count') ?></th>
                    <th><?= $this->Paginator->sort('clinic_outbound_count') ?></th>
                    <th><?= $this->Paginator->sort('patient_outbound_count') ?></th>
                    <th><?= $this->Paginator->sort('vm_outbound_count') ?></th>
                    <th><?= $this->Paginator->sort('is_locked') ?></th>
                    <th><?= $this->Paginator->sort('lock_time') ?></th>
                    <th><?= $this->Paginator->sort('id_locked_by_user') ?></th>
                    <th><?= $this->Paginator->sort('outbound_priority') ?></th>
                    <th><?= $this->Paginator->sort('question_visit_clinic') ?></th>
                    <th><?= $this->Paginator->sort('question_what_for') ?></th>
                    <th><?= $this->Paginator->sort('question_purchase') ?></th>
                    <th><?= $this->Paginator->sort('question_brand') ?></th>
                    <th><?= $this->Paginator->sort('question_brand_other') ?></th>
                    <th><?= $this->Paginator->sort('did_they_want_help') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('traffic_medium') ?></th>
                    <th><?= $this->Paginator->sort('is_appt_request_form') ?></th>
                    <th><?= $this->Paginator->sort('is_spam') ?></th>
                    <th><?= $this->Paginator->sort('id_xml_file') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($caCallGroups as $caCallGroup): ?>
                <tr>
                    <td><?= $this->Number->format($caCallGroup->id) ?></td>
                    <td><?= $caCallGroup->has('location') ? $this->Html->link($caCallGroup->location->title, ['controller' => 'Locations', 'action' => 'view', $caCallGroup->location->id]) : '' ?></td>
                    <td><?= h($caCallGroup->caller_phone) ?></td>
                    <td><?= h($caCallGroup->caller_first_name) ?></td>
                    <td><?= h($caCallGroup->caller_last_name) ?></td>
                    <td><?= h($caCallGroup->is_patient) ?></td>
                    <td><?= h($caCallGroup->patient_first_name) ?></td>
                    <td><?= h($caCallGroup->patient_last_name) ?></td>
                    <td><?= h($caCallGroup->refused_name) ?></td>
                    <td><?= h($caCallGroup->email) ?></td>
                    <td><?= h($caCallGroup->topic_wants_appt) ?></td>
                    <td><?= h($caCallGroup->topic_clinic_hours) ?></td>
                    <td><?= h($caCallGroup->topic_insurance) ?></td>
                    <td><?= h($caCallGroup->topic_clinic_inquiry) ?></td>
                    <td><?= h($caCallGroup->topic_aid_lost_old) ?></td>
                    <td><?= h($caCallGroup->topic_aid_lost_new) ?></td>
                    <td><?= h($caCallGroup->topic_warranty_old) ?></td>
                    <td><?= h($caCallGroup->topic_warranty_new) ?></td>
                    <td><?= h($caCallGroup->topic_batteries) ?></td>
                    <td><?= h($caCallGroup->topic_parts) ?></td>
                    <td><?= h($caCallGroup->topic_cancel_appt) ?></td>
                    <td><?= h($caCallGroup->topic_reschedule_appt) ?></td>
                    <td><?= h($caCallGroup->topic_appt_followup) ?></td>
                    <td><?= h($caCallGroup->topic_medical_records) ?></td>
                    <td><?= h($caCallGroup->topic_tinnitus) ?></td>
                    <td><?= h($caCallGroup->topic_hearing_previously_tested) ?></td>
                    <td><?= h($caCallGroup->topic_aids_previously_worn) ?></td>
                    <td><?= h($caCallGroup->topic_medical_inquiry) ?></td>
                    <td><?= h($caCallGroup->topic_solicitor) ?></td>
                    <td><?= h($caCallGroup->topic_personal_call) ?></td>
                    <td><?= h($caCallGroup->topic_request_fax) ?></td>
                    <td><?= h($caCallGroup->topic_request_name) ?></td>
                    <td><?= h($caCallGroup->topic_remove_from_list) ?></td>
                    <td><?= h($caCallGroup->topic_foreign_language) ?></td>
                    <td><?= h($caCallGroup->topic_other) ?></td>
                    <td><?= h($caCallGroup->topic_declined) ?></td>
                    <td><?= h($caCallGroup->wants_hearing_test) ?></td>
                    <td><?= h($caCallGroup->prospect) ?></td>
                    <td><?= h($caCallGroup->is_prospect_override) ?></td>
                    <td><?= h($caCallGroup->front_desk_name) ?></td>
                    <td><?= h($caCallGroup->score) ?></td>
                    <td><?= h($caCallGroup->status) ?></td>
                    <td><?= h($caCallGroup->appt_date) ?></td>
                    <td><?= h($caCallGroup->scheduled_call_date) ?></td>
                    <td><?= h($caCallGroup->final_score_date) ?></td>
                    <td><?= h($caCallGroup->is_bringing_third_party) ?></td>
                    <td><?= h($caCallGroup->is_review_needed) ?></td>
                    <td><?= $this->Number->format($caCallGroup->ca_call_count) ?></td>
                    <td><?= $this->Number->format($caCallGroup->clinic_followup_count) ?></td>
                    <td><?= $this->Number->format($caCallGroup->patient_followup_count) ?></td>
                    <td><?= $this->Number->format($caCallGroup->clinic_outbound_count) ?></td>
                    <td><?= $this->Number->format($caCallGroup->patient_outbound_count) ?></td>
                    <td><?= $this->Number->format($caCallGroup->vm_outbound_count) ?></td>
                    <td><?= h($caCallGroup->is_locked) ?></td>
                    <td><?= h($caCallGroup->lock_time) ?></td>
                    <td><?= $this->Number->format($caCallGroup->id_locked_by_user) ?></td>
                    <td><?= $this->Number->format($caCallGroup->outbound_priority) ?></td>
                    <td><?= h($caCallGroup->question_visit_clinic) ?></td>
                    <td><?= h($caCallGroup->question_what_for) ?></td>
                    <td><?= h($caCallGroup->question_purchase) ?></td>
                    <td><?= h($caCallGroup->question_brand) ?></td>
                    <td><?= h($caCallGroup->question_brand_other) ?></td>
                    <td><?= h($caCallGroup->did_they_want_help) ?></td>
                    <td><?= h($caCallGroup->created) ?></td>
                    <td><?= h($caCallGroup->modified) ?></td>
                    <td><?= h($caCallGroup->traffic_medium) ?></td>
                    <td><?= h($caCallGroup->is_appt_request_form) ?></td>
                    <td><?= h($caCallGroup->is_spam) ?></td>
                    <td><?= h($caCallGroup->id_xml_file) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $caCallGroup->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $caCallGroup->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $caCallGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id)]) ?>
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
