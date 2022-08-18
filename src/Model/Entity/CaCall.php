<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CaCall Entity
 *
 * @property int $id
 * @property int $ca_call_group_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property int $duration
 * @property string|null $call_type
 * @property string|null $recording_url
 * @property int $recording_duration
 *
 * @property \App\Model\Entity\CaCallGroup $ca_call_group
 * @property \App\Model\Entity\User $user
 */
class CaCall extends Entity
{
    /**
    * Enum - call type
    */
    const CALL_TYPE_INBOUND = 'inbound';
    const CALL_TYPE_INBOUND_QUICK_PICK = 'inbound_quick_pick';
    const CALL_TYPE_INBOUND_VM = 'inbound_voicemail';
    const CALL_TYPE_APPT_REQUEST_FORM = 'appt_request_form';
    const CALL_TYPE_ONLINE_BOOK = 'online_book';
    const CALL_TYPE_VM_CALLBACK_CLINIC = 'voicemail_callback_clinic';
    const CALL_TYPE_VM_CALLBACK_CONSUMER = 'voicemail_callback_consumer';
    const CALL_TYPE_VM_CALLBACK_INVALID = 'voicemail_callback_invalid';
    const CALL_TYPE_FOLLOWUP_APPT = 'followup_appt';
    const CALL_TYPE_FOLLOWUP_APPT_REQUEST = 'followup_appt_request';
    const CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT = 'followup_appt_request_direct';
    const CALL_TYPE_FOLLOWUP_NO_ANSWER = 'followup_no_answer';
    const CALL_TYPE_FOLLOWUP_TENTATIVE_APPT = 'followup_tentative_appt';
    const CALL_TYPE_OUTBOUND_CLINIC = 'outbound_clinic';
    const CALL_TYPE_OUTBOUND_CALLER = 'outbound_caller';
    const CALL_TYPE_SURVEY_DIRECT = 'survey_direct';
    static $callTypes = [
        self::CALL_TYPE_INBOUND => 'Inbound call',
        self::CALL_TYPE_INBOUND_QUICK_PICK => 'Inbound quick-pick call',
        self::CALL_TYPE_INBOUND_VM => 'Inbound voicemail',
        self::CALL_TYPE_APPT_REQUEST_FORM => 'Appointment request form',
        self::CALL_TYPE_ONLINE_BOOK => 'Online book via Blueprint/EarQ',
        self::CALL_TYPE_VM_CALLBACK_CLINIC => 'Voicemail callback to clinic',
        self::CALL_TYPE_VM_CALLBACK_CONSUMER => 'Voicemail callback to consumer',
        self::CALL_TYPE_VM_CALLBACK_INVALID => 'Invalid voicemail',
        self::CALL_TYPE_FOLLOWUP_APPT => 'Followup with clinic to set appointment',
        self::CALL_TYPE_FOLLOWUP_APPT_REQUEST => 'Followup - appt request form',
        self::CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT => 'Followup - appt request form - direct book',
        self::CALL_TYPE_FOLLOWUP_NO_ANSWER => 'Followup with consumer - clinic did not answer',
        self::CALL_TYPE_FOLLOWUP_TENTATIVE_APPT => 'Followup with clinic - verify tentative appt',
        self::CALL_TYPE_OUTBOUND_CLINIC => 'Survey call to clinic',
        self::CALL_TYPE_OUTBOUND_CALLER => 'Survey call to consumer',
        self::CALL_TYPE_SURVEY_DIRECT => 'Survey via direct booking system'
    ];

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
        'ca_call_group_id' => true,
        'user_id' => true,
        'start_time' => true,
        'duration' => true,
        'call_type' => true,
        'recording_url' => true,
        'recording_duration' => true,
        'ca_call_group' => true,
        'user' => true,
    ];
}
