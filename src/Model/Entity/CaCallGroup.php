<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CaCallGroup Entity
 *
 * @property int $id
 * @property int $location_id
 * @property string|null $caller_phone
 * @property string|null $caller_first_name
 * @property string|null $caller_last_name
 * @property bool $is_patient
 * @property string|null $patient_first_name
 * @property string|null $patient_last_name
 * @property bool $refused_name
 * @property string|null $email
 * @property bool $topic_wants_appt
 * @property bool $topic_clinic_hours
 * @property bool $topic_insurance
 * @property bool $topic_clinic_inquiry
 * @property bool $topic_aid_lost_old
 * @property bool $topic_aid_lost_new
 * @property bool $topic_warranty_old
 * @property bool $topic_warranty_new
 * @property bool $topic_batteries
 * @property bool $topic_parts
 * @property bool $topic_cancel_appt
 * @property bool $topic_reschedule_appt
 * @property bool $topic_appt_followup
 * @property bool $topic_medical_records
 * @property bool $topic_tinnitus
 * @property bool $topic_hearing_previously_tested
 * @property bool $topic_aids_previously_worn
 * @property bool $topic_medical_inquiry
 * @property bool $topic_solicitor
 * @property bool $topic_personal_call
 * @property bool $topic_request_fax
 * @property bool $topic_request_name
 * @property bool $topic_remove_from_list
 * @property bool $topic_foreign_language
 * @property bool $topic_other
 * @property bool $topic_declined
 * @property bool $wants_hearing_test
 * @property string|null $prospect
 * @property bool $is_prospect_override
 * @property string|null $front_desk_name
 * @property string|null $score
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $appt_date
 * @property \Cake\I18n\FrozenTime|null $scheduled_call_date
 * @property \Cake\I18n\FrozenTime|null $final_score_date
 * @property bool $is_bringing_third_party
 * @property bool $is_review_needed
 * @property int $ca_call_count
 * @property int $clinic_followup_count
 * @property int $patient_followup_count
 * @property int $clinic_outbound_count
 * @property int $patient_outbound_count
 * @property int $vm_outbound_count
 * @property bool $is_locked
 * @property \Cake\I18n\FrozenTime|null $lock_time
 * @property int $id_locked_by_user
 * @property float|null $outbound_priority
 * @property string|null $question_visit_clinic
 * @property string|null $question_what_for
 * @property string|null $question_purchase
 * @property string|null $question_brand
 * @property string|null $question_brand_other
 * @property bool $did_they_want_help
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $traffic_source
 * @property string $traffic_medium
 * @property bool $is_appt_request_form
 * @property bool $is_spam
 * @property string $id_xml_file
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\CaCallGroupNote[] $ca_call_group_notes
 * @property \App\Model\Entity\CaCall[] $ca_calls
 */
class CaCallGroup extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<bool>
     */
    protected $_accessible = [
        'location_id' => true,
        'caller_phone' => true,
        'caller_first_name' => true,
        'caller_last_name' => true,
        'is_patient' => true,
        'patient_first_name' => true,
        'patient_last_name' => true,
        'refused_name' => true,
        'email' => true,
        'topic_wants_appt' => true,
        'topic_clinic_hours' => true,
        'topic_insurance' => true,
        'topic_clinic_inquiry' => true,
        'topic_aid_lost_old' => true,
        'topic_aid_lost_new' => true,
        'topic_warranty_old' => true,
        'topic_warranty_new' => true,
        'topic_batteries' => true,
        'topic_parts' => true,
        'topic_cancel_appt' => true,
        'topic_reschedule_appt' => true,
        'topic_appt_followup' => true,
        'topic_medical_records' => true,
        'topic_tinnitus' => true,
        'topic_hearing_previously_tested' => true,
        'topic_aids_previously_worn' => true,
        'topic_medical_inquiry' => true,
        'topic_solicitor' => true,
        'topic_personal_call' => true,
        'topic_request_fax' => true,
        'topic_request_name' => true,
        'topic_remove_from_list' => true,
        'topic_foreign_language' => true,
        'topic_other' => true,
        'topic_declined' => true,
        'wants_hearing_test' => true,
        'prospect' => true,
        'is_prospect_override' => true,
        'front_desk_name' => true,
        'score' => true,
        'status' => true,
        'appt_date' => true,
        'scheduled_call_date' => true,
        'final_score_date' => true,
        'is_bringing_third_party' => true,
        'is_review_needed' => true,
        'ca_call_count' => true,
        'clinic_followup_count' => true,
        'patient_followup_count' => true,
        'clinic_outbound_count' => true,
        'patient_outbound_count' => true,
        'vm_outbound_count' => true,
        'is_locked' => true,
        'lock_time' => true,
        'id_locked_by_user' => true,
        'outbound_priority' => true,
        'question_visit_clinic' => true,
        'question_what_for' => true,
        'question_purchase' => true,
        'question_brand' => true,
        'question_brand_other' => true,
        'did_they_want_help' => true,
        'created' => true,
        'modified' => true,
        'traffic_source' => true,
        'traffic_medium' => true,
        'is_appt_request_form' => true,
        'is_spam' => true,
        'id_xml_file' => true,
        'location' => true,
        'ca_call_group_notes' => true,
        'ca_calls' => true,
    ];
}
