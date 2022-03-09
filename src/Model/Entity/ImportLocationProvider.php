<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportLocationProvider Entity
 *
 * @property int $id
 * @property int|null $import_id
 * @property int|null $import_location_id
 * @property int|null $import_provider_id
 *
 * @property \App\Model\Entity\Import $import
 * @property \App\Model\Entity\ImportLocation $import_location
 * @property \App\Model\Entity\ImportProvider $import_provider
 */
class ImportLocationProvider extends Entity
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
        'import_location_id' => true,
        'import_provider_id' => true,
        'import' => true,
        'import_location' => true,
        'import_provider' => true,
    ];
}
