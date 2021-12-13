<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup $caCallGroup
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Ca Call Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="caCallGroups form content">
            <?= $this->Form->create($caCallGroup) ?>
            <fieldset>
                <legend><?= __('Add Ca Call Group') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('caller_phone');
                    echo $this->Form->control('caller_first_name');
                    echo $this->Form->control('caller_last_name');
                    echo $this->Form->control('is_patient');
                    echo $this->Form->control('patient_first_name');
                    echo $this->Form->control('patient_last_name');
                    echo $this->Form->control('refused_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('topic_wants_appt');
                    echo $this->Form->control('topic_clinic_hours');
                    echo $this->Form->control('topic_insurance');
                    echo $this->Form->control('topic_clinic_inquiry');
                    echo $this->Form->control('topic_aid_lost_old');
                    echo $this->Form->control('topic_aid_lost_new');
                    echo $this->Form->control('topic_warranty_old');
                    echo $this->Form->control('topic_warranty_new');
                    echo $this->Form->control('topic_batteries');
                    echo $this->Form->control('topic_parts');
                    echo $this->Form->control('topic_cancel_appt');
                    echo $this->Form->control('topic_reschedule_appt');
                    echo $this->Form->control('topic_appt_followup');
                    echo $this->Form->control('topic_medical_records');
                    echo $this->Form->control('topic_tinnitus');
                    echo $this->Form->control('topic_hearing_previously_tested');
                    echo $this->Form->control('topic_aids_previously_worn');
                    echo $this->Form->control('topic_medical_inquiry');
                    echo $this->Form->control('topic_solicitor');
                    echo $this->Form->control('topic_personal_call');
                    echo $this->Form->control('topic_request_fax');
                    echo $this->Form->control('topic_request_name');
                    echo $this->Form->control('topic_remove_from_list');
                    echo $this->Form->control('topic_foreign_language');
                    echo $this->Form->control('topic_other');
                    echo $this->Form->control('topic_declined');
                    echo $this->Form->control('wants_hearing_test');
                    echo $this->Form->control('prospect');
                    echo $this->Form->control('is_prospect_override');
                    echo $this->Form->control('front_desk_name');
                    echo $this->Form->control('score');
                    echo $this->Form->control('status');
                    echo $this->Form->control('appt_date', ['empty' => true]);
                    echo $this->Form->control('scheduled_call_date', ['empty' => true]);
                    echo $this->Form->control('final_score_date', ['empty' => true]);
                    echo $this->Form->control('is_bringing_third_party');
                    echo $this->Form->control('is_review_needed');
                    echo $this->Form->control('ca_call_count');
                    echo $this->Form->control('clinic_followup_count');
                    echo $this->Form->control('patient_followup_count');
                    echo $this->Form->control('clinic_outbound_count');
                    echo $this->Form->control('patient_outbound_count');
                    echo $this->Form->control('vm_outbound_count');
                    echo $this->Form->control('is_locked');
                    echo $this->Form->control('lock_time', ['empty' => true]);
                    echo $this->Form->control('id_locked_by_user');
                    echo $this->Form->control('outbound_priority');
                    echo $this->Form->control('question_visit_clinic');
                    echo $this->Form->control('question_what_for');
                    echo $this->Form->control('question_purchase');
                    echo $this->Form->control('question_brand');
                    echo $this->Form->control('question_brand_other');
                    echo $this->Form->control('did_they_want_help');
                    echo $this->Form->control('traffic_source');
                    echo $this->Form->control('traffic_medium');
                    echo $this->Form->control('is_appt_request_form');
                    echo $this->Form->control('is_spam');
                    echo $this->Form->control('id_xml_file');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
