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
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
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
