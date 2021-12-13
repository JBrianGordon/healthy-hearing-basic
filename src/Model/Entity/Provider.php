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
 * @property string|null $square_url
 * @property string|null $thumb_url
 * @property string|null $image_url
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $phone
 * @property int $order
 * @property string|null $aud_or_his
 * @property string|null $caqh_number
 * @property string|null $npi_number
 * @property bool $show_npi
 * @property bool $is_ida_verified
 * @property string|null $licenses
 * @property bool $show_license
 * @property int|null $id_yhn_provider
 *
 * @property \App\Model\Entity\ImportProvider[] $import_providers
 * @property \App\Model\Entity\LocationProvider[] $location_providers
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
     * @var array
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
        'square_url' => true,
        'thumb_url' => true,
        'image_url' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'phone' => true,
        'order' => true,
        'aud_or_his' => true,
        'caqh_number' => true,
        'npi_number' => true,
        'show_npi' => true,
        'is_ida_verified' => true,
        'licenses' => true,
        'show_license' => true,
        'id_yhn_provider' => true,
        'import_providers' => true,
        'location_providers' => true,
    ];
}
