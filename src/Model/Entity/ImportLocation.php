<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportLocation Entity
 *
 * @property int $id
 * @property int|null $import_id
 * @property string $id_external
 * @property int|null $location_id
 * @property string|null $id_oticon
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $email
 * @property string|null $address
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone
 * @property int|null $match_type
 * @property bool $is_retail
 * @property bool $is_new
 *
 * @property \App\Model\Entity\Import $import
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\ImportLocationProvider[] $import_location_providers
 */
class ImportLocation extends Entity
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
        'import_id' => true,
        'id_external' => true,
        'location_id' => true,
        'id_oticon' => true,
        'title' => true,
        'subtitle' => true,
        'email' => true,
        'address' => true,
        'address_2' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'phone' => true,
        'match_type' => true,
        'is_retail' => true,
        'is_new' => true,
        'import' => true,
        'location' => true,
        'import_location_providers' => true,
    ];
}
