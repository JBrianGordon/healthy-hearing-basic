<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationProvider Entity
 *
 * @property int $id
 * @property int|null $location_id
 * @property int|null $provider_id
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Provider $provider
 */
class LocationProvider extends Entity
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
        'provider_id' => true,
        'location' => true,
        'provider' => true,
    ];
}
