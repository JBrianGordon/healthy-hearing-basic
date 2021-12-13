<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CsCall Entity
 *
 * @property int $id
 * @property int $call_id
 * @property int $location_id
 * @property string|null $ad_source
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property string $result
 * @property int $duration
 * @property string|null $call_type
 * @property string|null $call_status
 * @property string|null $leadscore
 * @property string|null $recording_url
 * @property string $tracking_number
 * @property string $caller_phone
 * @property string $clinic_phone
 * @property string|null $caller_firstname
 * @property string|null $caller_lastname
 * @property string|null $prospect
 *
 * @property \App\Model\Entity\Call $call
 * @property \App\Model\Entity\Location $location
 */
class CsCall extends Entity
{
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
        'call_id' => true,
        'location_id' => true,
        'ad_source' => true,
        'start_time' => true,
        'result' => true,
        'duration' => true,
        'call_type' => true,
        'call_status' => true,
        'leadscore' => true,
        'recording_url' => true,
        'tracking_number' => true,
        'caller_phone' => true,
        'clinic_phone' => true,
        'caller_firstname' => true,
        'caller_lastname' => true,
        'prospect' => true,
        'call' => true,
        'location' => true,
    ];
}
