<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CountMetric Entity
 *
 * @property string $id
 * @property string $type
 * @property string $metric
 * @property string $name
 * @property string $sub_name
 * @property int $count
 * @property \Cake\I18n\FrozenTime|null $updated
 * @property \Cake\I18n\FrozenTime|null $created
 */
class CountMetric extends Entity
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
        'metric' => true,
        'name' => true,
        'sub_name' => true,
        'count' => true,
        'updated' => true,
        'created' => true,
    ];
}
