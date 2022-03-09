<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationUser Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $lastlogin
 * @property bool $is_active
 * @property string|null $reset_url
 * @property \Cake\I18n\FrozenTime|null $reset_expiration_date
 * @property string|null $clinic_password
 * @property int $location_id
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\LocationUserLogin[] $location_user_logins
 */
class LocationUser extends Entity
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
        'username' => true,
        'password' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'lastlogin' => true,
        'is_active' => true,
        'reset_url' => true,
        'reset_expiration_date' => true,
        'clinic_password' => true,
        'location_id' => true,
        'location' => true,
        'location_user_logins' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
