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
    * Enum - is prospect
    */
    const PROSPECT_YES = 'prospect';
    const PROSPECT_NO = 'non_prospect';
    const PROSPECT_UNKNOWN = 'prospect_unknown';
    const PROSPECT_DISCONNECTED = 'disconnected';
    static $prospectOptions = array(
        self::PROSPECT_YES => 'Yes',
        self::PROSPECT_NO => 'No',
        self::PROSPECT_UNKNOWN => 'Unknown',
        self::PROSPECT_DISCONNECTED => 'Caller disconnected',
    );

    /**
    * Enum - score
    */
    const SCORE_DISCONNECTED = 'disconnected';
    const SCORE_MISSED_OPPORTUNITY = 'missed_opportunity';
    const SCORE_APPT_SET = 'appt_set';
    const SCORE_TENTATIVE_APPT = 'tentative_appt';
    const SCORE_APPT_SET_DIRECT = 'appt_set_direct';
    const SCORE_NOT_REACHED = 'clinic_not_reached';
    static $scores = array(
        self::SCORE_DISCONNECTED => 'Caller disconnected or hung up',
        self::SCORE_MISSED_OPPORTUNITY => 'Clinic missed opportunity',
        self::SCORE_APPT_SET => 'Clinic set appointment',
        self::SCORE_TENTATIVE_APPT => 'Tentative appointment',
        self::SCORE_APPT_SET_DIRECT => 'Appointment set via direct booking',
        self::SCORE_NOT_REACHED => 'Not able to reach clinic',
    );

    /*
    * Enum - status
    */
    const STATUS_NEW = 'new';
    const STATUS_WRONG_NUMBER = 'wrong_number';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_VM_NEEDS_CALLBACK = 'vm_needs_callback';
    const STATUS_VM_CALLBACK_ATTEMPTED = 'vm_callback_attempted';
    const STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS = 'vm_callback_too_many_attempts';
    const STATUS_FOLLOWUP_SET_APPT = 'needs_followup';
    const STATUS_FOLLOWUP_NO_ANSWER = 'needs_followup_no_answer';
    const STATUS_FOLLOWUP_APPT_REQUEST_FORM = 'followup_appt_request_form';
    const STATUS_APPT_SET = 'appt_set';
    const STATUS_TENTATIVE_APPT = 'tentative_appt';
    const STATUS_MISSED_OPPORTUNITY = 'missed_opportunity';
    const STATUS_MO_NO_ANSWER = 'mo_clinic_no_answer';
    const STATUS_NON_PROSPECT = 'non_prospect';
    const STATUS_OUTBOUND_CLINIC_ATTEMPTED = 'outbound_clinic_attempted';
    const STATUS_OUTBOUND_CLINIC_TOO_MANY_ATTEMPTS = 'outbound_clinic_too_many_attempts';
    const STATUS_OUTBOUND_CLINIC_DECLINED = 'outbound_clinic_declined';
    const STATUS_OUTBOUND_CLINIC_COMPLETE = 'outbound_clinic_complete';
    const STATUS_OUTBOUND_CUST_ATTEMPTED = 'outbound_cust_attempted';
    const STATUS_OUTBOUND_CUST_DECLINED = 'outbound_cust_declined';
    const STATUS_OUTBOUND_CUST_SURVEY_COMPLETE = 'outbound_cust_complete';
    const STATUS_OUTBOUND_CUST_TOO_MANY_ATTEMPTS = 'outbound_cust_too_many_attempts';
    const STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS = 'quick_pick_refused_name';
    const STATUS_QUICK_PICK_CALLER_REFUSED_HELP = 'quick_pick_caller_refused_help';
    static $statuses = [
        self::STATUS_NEW => 'New',
        self::STATUS_WRONG_NUMBER => 'Wrong number / never connected',
        self::STATUS_INCOMPLETE => 'Incomplete / Disconnected',
        self::STATUS_VM_NEEDS_CALLBACK => 'Voicemail needs callback',
        self::STATUS_VM_CALLBACK_ATTEMPTED => 'Voicemail callback attempted',
        self::STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS => 'Voicemail callback - too many attempts',
        self::STATUS_FOLLOWUP_SET_APPT => 'Needs followup to set appt',
        self::STATUS_FOLLOWUP_NO_ANSWER => 'Needs followup to consumer - clinic did not answer',
        self::STATUS_FOLLOWUP_APPT_REQUEST_FORM => 'Needs followup to set appt (appt request form)',
        self::STATUS_APPT_SET => 'Appointment Set',
        self::STATUS_TENTATIVE_APPT => 'Tentative appointment',
        self::STATUS_MISSED_OPPORTUNITY => 'Complete (missed opportunity)',
        self::STATUS_MO_NO_ANSWER => 'Complete (MO - Clinic no answer)',
        self::STATUS_NON_PROSPECT => 'Complete (non-prospect)',
        self::STATUS_OUTBOUND_CLINIC_ATTEMPTED => 'Clinic survey attempted',
        self::STATUS_OUTBOUND_CLINIC_TOO_MANY_ATTEMPTS => 'Clinic survey - too many attempts',
        self::STATUS_OUTBOUND_CLINIC_DECLINED => 'Clinic survey declined',
        self::STATUS_OUTBOUND_CLINIC_COMPLETE => 'Clinic survey complete',
        self::STATUS_OUTBOUND_CUST_ATTEMPTED => 'Consumer survey attempted',
        self::STATUS_OUTBOUND_CUST_DECLINED => 'Consumer survey declined',
        self::STATUS_OUTBOUND_CUST_SURVEY_COMPLETE => 'Consumer survey complete',
        self::STATUS_OUTBOUND_CUST_TOO_MANY_ATTEMPTS => 'Consumer survey - too many attempts',
        self::STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS => 'Quick Pick - Refused Name/Address',
        self::STATUS_QUICK_PICK_CALLER_REFUSED_HELP => 'Quick Pick - Caller Refused Help'
    ];

    /*
    * Enum - topics
    */
    const TOPIC_WANTS_APPT = 'topic_wants_appt';
    const TOPIC_CLINIC_HOURS = 'topic_clinic_hours';
    const TOPIC_INSURANCE = 'topic_insurance';
    const TOPIC_CLINIC_INQUIRY = 'topic_clinic_inquiry';
    const TOPIC_AID_LOST_OLD = 'topic_aid_lost_old';
    const TOPIC_AID_LOST_NEW = 'topic_aid_lost_new';
    const TOPIC_WARRANTY_OLD = 'topic_warranty_old';
    const TOPIC_WARRANTY_NEW = 'topic_warranty_new';
    const TOPIC_CANCEL_APPT = 'topic_cancel_appt';
    const TOPIC_RESCHEDULE_APPT = 'topic_reschedule_appt';
    const TOPIC_APPT_FOLLOWUP = 'topic_appt_followup';
    const TOPIC_BATTERIES = 'topic_batteries';
    const TOPIC_PARTS = 'topic_parts';
    const TOPIC_MEDICAL_RECORDS = 'topic_medical_records';
    const TOPIC_TINNITUS = 'topic_tinnitus';
    const TOPIC_MEDICAL_INQUIRY = 'topic_medical_inquiry';
    const TOPIC_SOLICITOR = 'topic_solicitor';
    const TOPIC_PERSONAL_CALL = 'topic_personal_call';
    const TOPIC_REQUEST_FAX = 'topic_request_fax';
    const TOPIC_REQUEST_NAME = 'topic_request_name';
    const TOPIC_REMOVE_FROM_LIST = 'topic_remove_from_list';
    const TOPIC_FOREIGN_LANGUAGE = 'topic_foreign_language';
    const TOPIC_OTHER = 'topic_other';
    const TOPIC_DECLINED = 'topic_declined';
    static $col1Topics = [
        self::TOPIC_WANTS_APPT => 'Hearing test / hearing aid consultation',
        self::TOPIC_CLINIC_HOURS => 'Clinic hours / directions',
        self::TOPIC_INSURANCE => 'Insurance inquiry',
        self::TOPIC_CLINIC_INQUIRY => 'General inquiry <small>(hearing loss, products)</small>',
        self::TOPIC_AID_LOST_OLD => 'Hearing aid lost/broken - Hearing aid is 3 years or older',
        self::TOPIC_AID_LOST_NEW => 'Hearing aid lost/broken - Hearing aid is less than 3 years old',
        self::TOPIC_WARRANTY_OLD => 'Hearing aid warranty question - Hearing aid is 3 years or older',
        self::TOPIC_WARRANTY_NEW => 'Hearing aid warranty question - Hearing aid is less than 3 years old',
        self::TOPIC_CANCEL_APPT => 'Cancel appointment / Confirm appointment',
        self::TOPIC_RESCHEDULE_APPT => 'Reschedule appointment',
        self::TOPIC_APPT_FOLLOWUP => 'Followup after recent appointment or fitting',
        self::TOPIC_BATTERIES => 'Need to buy batteries',
        self::TOPIC_PARTS => 'Need to buy parts <small>(domes, earmolds, wax guards)</small>',
    ];
    static $col2Topics = [
        self::TOPIC_MEDICAL_RECORDS => 'Request medical records',
        self::TOPIC_TINNITUS => 'Ringing in ear / Tinnitus',
        self::TOPIC_MEDICAL_INQUIRY => 'Medical inquiry <small>(APD, wax removal, dizziness, ear infection)</small>',
        self::TOPIC_SOLICITOR => 'Solicitor',
        self::TOPIC_PERSONAL_CALL => 'Personal call',
        self::TOPIC_REQUEST_FAX => 'Request fax number',
        self::TOPIC_REQUEST_NAME => 'Request person in clinic by name',
        self::TOPIC_REMOVE_FROM_LIST => 'Remove from marketing list',
        self::TOPIC_FOREIGN_LANGUAGE => 'Foreign language',
        self::TOPIC_OTHER => 'Other',
        self::TOPIC_DECLINED => 'Caller refused to answer question',
    ];
    /* These are the prospect topic fields */
    static $prospectTopics = [
        'CaCallGroupTopicWantsAppt',
        'CaCallGroupTopicClinicHours',
        'CaCallGroupTopicInsurance',
        'CaCallGroupTopicClinicInquiry',
        'CaCallGroupTopicAidLostOld',
        'CaCallGroupTopicWarrantyOld',
        'CaCallGroupTopicRescheduleAppt',
        'CaCallGroupTopicTinnitus',
    ];

    /**
    * Enum - Question: Did patient make it to appt?
    */
    const Q_VISIT_CLINIC_YES = 'yes';
    const Q_VISIT_CLINIC_NO_RESCHEDULED = 'no_rescheduled';
    const Q_VISIT_CLINIC_NO_CANCELLED = 'no_cancelled';
    const Q_VISIT_CLINIC_DECLINED = 'declined';
    static $questionVisitClinicAnswers = array(
        self::Q_VISIT_CLINIC_YES => 'Yes',
        self::Q_VISIT_CLINIC_NO_RESCHEDULED => 'No, appt is coming up',
        self::Q_VISIT_CLINIC_NO_CANCELLED => 'No, cancelled appt and did not reschedule',
        self::Q_VISIT_CLINIC_DECLINED => 'Refused to answer question',
    );
    /**
    * Enum - Question: What did patient have done at appt?
    */
    const Q_WHAT_FOR_HEARING_TEST = 'hearing_test';
    const Q_WHAT_FOR_HEARING_AID_CONSULT = 'hearing_aid_consultation';
    const Q_WHAT_FOR_HEARING_AID_REPAIR = 'hearing_aid_checkup_repair';
    const Q_WHAT_FOR_OTHER_DR = 'other_doctors_appt';
    const Q_WHAT_FOR_DECLINED = 'declined';
    static $questionWhatForAnswers = array(
        self::Q_WHAT_FOR_HEARING_TEST => 'Hearing Test',
        self::Q_WHAT_FOR_HEARING_AID_CONSULT => 'Hearing Aid Consultation',
        self::Q_WHAT_FOR_HEARING_AID_REPAIR => 'Hearing Aid Checkup/Repair',
        self::Q_WHAT_FOR_OTHER_DR => 'Other Doctor\'s Appointment',
        self::Q_WHAT_FOR_DECLINED => 'Refused to answer question',
    );
    /**
    * Enum - Question: Did patient purchase a hearing aid?
    */
    const Q_PURCHASE_YES = 'Yes';
    const Q_PURCHASE_NO = 'No';
    const Q_PURCHASE_DECLINED = 'declined';
    static $questionPurchaseAnswers = array(
        self::Q_PURCHASE_YES => 'Yes',
        self::Q_PURCHASE_NO => 'No',
        self::Q_PURCHASE_DECLINED => 'Refused to answer question',
    );
    /**
    * Enum - Question: What brand of hearing aid did they purchase?
    */
    const Q_BRAND_OTICON = 'Oticon';
    const Q_BRAND_AGXO = 'AGXO';
    const Q_BRAND_RESOUND = 'Resound';
    const Q_BRAND_STARKEY = 'Starkey';
    const Q_BRAND_PHONAK = 'Phonak';
    const Q_BRAND_WIDEX = 'Widex';
    const Q_BRAND_UNITRON = 'Unitron';
    const Q_BRAND_SIEMENS = 'Siemens';
    const Q_BRAND_UNKNOWN = 'unknown';
    const Q_BRAND_OTHER = 'Other';
    const Q_BRAND_DECLINED = 'declined';
    static $questionBrandAnswers = array(
        self::Q_BRAND_OTICON => 'Oticon',
        self::Q_BRAND_AGXO => 'AGXO',
        self::Q_BRAND_RESOUND => 'Resound',
        self::Q_BRAND_STARKEY => 'Starkey',
        self::Q_BRAND_PHONAK => 'Phonak',
        self::Q_BRAND_WIDEX => 'Widex',
        self::Q_BRAND_UNITRON => 'Unitron',
        self::Q_BRAND_SIEMENS => 'Sivantos / Siemens / Signia',
        self::Q_BRAND_UNKNOWN => 'Can\'t remember',
        self::Q_BRAND_OTHER => 'Other brand',
        self::Q_BRAND_DECLINED => 'Refused to answer question',
    );
    /**
    * Maximum outbound call attempts allowed
    */
    const MAX_VM_OUTBOUND_ATTEMPTS = 3;
    // Appointments
    const MAX_CLINIC_FOLLOWUP_ATTEMPTS = 6;
    const MAX_PATIENT_FOLLOWUP_ATTEMPTS = 3;
    // Surveys
    const MAX_CLINIC_OUTBOUND_ATTEMPTS = 4;
    const MAX_PATIENT_OUTBOUND_ATTEMPTS = 4;
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
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
