<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationPhoto Entity
 *
 * @property int $id
 * @property int $location_id
 * @property string|null $photo_name
 * @property string|null $photo_url
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $alt
 *
 * @property \App\Model\Entity\Location $location
 */
class LocationPhoto extends Entity
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
        'photo_name' => true,
        'photo_url' => true,
        'created' => true,
        'modified' => true,
        'alt' => true,
        'location' => true,
    ];
}
