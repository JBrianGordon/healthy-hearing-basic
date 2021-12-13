<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CallSource Entity
 *
 * @property int $id
 * @property string $customer_name
 * @property int $location_id
 * @property bool $is_active
 * @property string|null $notes
 * @property string $phone_number
 * @property string $target_number
 * @property string $clinic_number
 * @property string $start_date
 * @property string $end_date
 * @property \Cake\I18n\FrozenTime|null $created
 * @property bool $is_ivr_enabled
 *
 * @property \App\Model\Entity\Location $location
 */
class CallSource extends Entity
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
        'customer_name' => true,
        'location_id' => true,
        'is_active' => true,
        'notes' => true,
        'phone_number' => true,
        'target_number' => true,
        'clinic_number' => true,
        'start_date' => true,
        'end_date' => true,
        'created' => true,
        'is_ivr_enabled' => true,
        'location' => true,
    ];
}
