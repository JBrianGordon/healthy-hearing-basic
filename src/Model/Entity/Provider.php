<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Provider Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $credentials
 * @property string|null $title
 * @property string|null $email
 * @property string|null $description
 * @property string|null $micro_url
 * @property string|null $photo_name
 * @property string|null $thumb_url
 * @property string|null $image_url
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $phone
 * @property int $priority
 * @property string|null $aud_or_his
 * @property int|null $id_yhn_provider
 * @property int $location_count
 *
 * @property \App\Model\Entity\ImportProvider[] $import_providers
 * @property \App\Model\Entity\LocationProvider[] $locations_providers
 */
class Provider extends Entity
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
        'first_name' => true,
        'middle_name' => true,
        'last_name' => true,
        'credentials' => true,
        'title' => true,
        'email' => true,
        'description' => true,
        'micro_url' => true,
        'photo_name' => true,
        'thumb_url' => true,
        'image_url' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'phone' => true,
        'priority' => true,
        'aud_or_his' => true,
        'id_yhn_provider' => true,
        'import_providers' => true,
        'locations' => true,
    ];
}
