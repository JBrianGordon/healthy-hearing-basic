<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationNote Entity
 *
 * @property int $id
 * @property int $location_id
 * @property string|null $body
 * @property int $status
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\User $user
 */
class LocationNote extends Entity
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
        'body' => true,
        'status' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'location' => true,
        'user' => true,
    ];
}
