<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationLink Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $id_linked_location
 * @property int $distance
 *
 * @property \App\Model\Entity\Location $location
 */
class LocationLink extends Entity
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
        'location_id' => true,
        'id_linked_location' => true,
        'distance' => true,
        'location' => true,
    ];
}
