<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportProvider Entity
 *
 * @property int $id
 * @property int|null $import_id
 * @property int|null $id_external
 * @property int|null $provider_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $aud_or_his
 *
 * @property \App\Model\Entity\Import $import
 * @property \App\Model\Entity\Provider $provider
 * @property \App\Model\Entity\ImportLocationProvider[] $import_location_providers
 */
class ImportProvider extends Entity
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
        'provider_id' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'aud_or_his' => true,
        'import' => true,
        'provider' => true,
        'import_location_providers' => true,
    ];
}
