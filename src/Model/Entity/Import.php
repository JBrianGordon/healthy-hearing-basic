<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Import Entity
 *
 * @property int $id
 * @property string|null $type
 * @property int|null $total_locations
 * @property int|null $new_locations
 * @property int|null $updated_locations
 * @property int|null $total_providers
 * @property int|null $new_providers
 * @property int|null $updated_providers
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\ImportDiff[] $import_diffs
 * @property \App\Model\Entity\ImportLocationProvider[] $import_location_providers
 * @property \App\Model\Entity\ImportLocation[] $import_locations
 * @property \App\Model\Entity\ImportProvider[] $import_providers
 */
class Import extends Entity
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
        'type' => true,
        'total_locations' => true,
        'new_locations' => true,
        'updated_locations' => true,
        'total_providers' => true,
        'new_providers' => true,
        'updated_providers' => true,
        'created' => true,
        'import_diffs' => true,
        'import_location_providers' => true,
        'import_locations' => true,
        'import_providers' => true,
    ];
}
