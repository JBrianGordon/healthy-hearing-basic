<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportStatus Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $status
 * @property int $oticon_tier
 * @property string $listing_type
 * @property bool|null $is_active
 * @property bool|null $is_show
 * @property bool|null $is_grace_period
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\Location $location
 */
class ImportStatus extends Entity
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
        'status' => true,
        'oticon_tier' => true,
        'listing_type' => true,
        'is_active' => true,
        'is_show' => true,
        'is_grace_period' => true,
        'created' => true,
        'location' => true,
    ];
}
