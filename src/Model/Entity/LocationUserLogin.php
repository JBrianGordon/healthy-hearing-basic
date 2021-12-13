<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationUserLogin Entity
 *
 * @property int $id
 * @property int $location_user_id
 * @property \Cake\I18n\FrozenTime|null $login_date
 * @property string|null $ip
 *
 * @property \App\Model\Entity\LocationUser $location_user
 */
class LocationUserLogin extends Entity
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
        'location_user_id' => true,
        'login_date' => true,
        'ip' => true,
        'location_user' => true,
    ];
}
