<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CaCallGroupsFixture
 */
class CaCallGroupsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'location_id' => 1,
                'caller_phone' => 'Lorem ipsum dolor ',
                'caller_first_name' => 'Lorem ipsum dolor sit amet',
                'caller_last_name' => 'Lorem ipsum dolor sit amet',
                'is_patient' => 1,
                'patient_first_name' => 'Lorem ipsum dolor sit amet',
                'patient_last_name' => 'Lorem ipsum dolor sit amet',
                'refused_name' => 1,
                'email' => 'Lorem ipsum dolor sit amet',
                'topic_wants_appt' => 1,
                'topic_clinic_hours' => 1,
                'topic_insurance' => 1,
                'topic_clinic_inquiry' => 1,
                'topic_aid_lost_old' => 1,
                'topic_aid_lost_new' => 1,
                'topic_warranty_old' => 1,
                'topic_warranty_new' => 1,
                'topic_batteries' => 1,
                'topic_parts' => 1,
                'topic_cancel_appt' => 1,
                'topic_reschedule_appt' => 1,
                'topic_appt_followup' => 1,
                'topic_medical_records' => 1,
                'topic_tinnitus' => 1,
                'topic_hearing_previously_tested' => 1,
                'topic_aids_previously_worn' => 1,
                'topic_medical_inquiry' => 1,
                'topic_solicitor' => 1,
                'topic_personal_call' => 1,
                'topic_request_fax' => 1,
                'topic_request_name' => 1,
                'topic_remove_from_list' => 1,
                'topic_foreign_language' => 1,
                'topic_other' => 1,
                'topic_declined' => 1,
                'wants_hearing_test' => 1,
                'prospect' => 'Lorem ipsum dolor sit amet',
                'is_prospect_override' => 1,
                'front_desk_name' => 'Lorem ipsum dolor sit amet',
                'score' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'appt_date' => '2021-12-10 21:23:54',
                'scheduled_call_date' => '2021-12-10 21:23:54',
                'final_score_date' => '2021-12-10 21:23:54',
                'is_bringing_third_party' => 1,
                'is_review_needed' => 1,
                'ca_call_count' => 1,
                'clinic_followup_count' => 1,
                'patient_followup_count' => 1,
                'clinic_outbound_count' => 1,
                'patient_outbound_count' => 1,
                'vm_outbound_count' => 1,
                'is_locked' => 1,
                'lock_time' => '2021-12-10 21:23:54',
                'id_locked_by_user' => 1,
                'outbound_priority' => 1,
                'question_visit_clinic' => 'Lorem ipsum dolor sit amet',
                'question_what_for' => 'Lorem ipsum dolor sit amet',
                'question_purchase' => 'Lorem ipsum dolor sit amet',
                'question_brand' => 'Lorem ipsum dolor sit amet',
                'question_brand_other' => 'Lorem ipsum dolor sit amet',
                'did_they_want_help' => 1,
                'created' => '2021-12-10 21:23:54',
                'modified' => '2021-12-10 21:23:54',
                'traffic_source' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'traffic_medium' => 'Lorem ipsum dolor sit amet',
                'is_appt_request_form' => 1,
                'is_spam' => 1,
                'id_xml_file' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
