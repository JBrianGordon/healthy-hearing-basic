<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoBlacklist Entity
 *
 * @property int $id
 * @property int $ip_range_start
 * @property int $ip_range_end
 * @property string|null $note
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $is_active
 */
class SeoBlacklist extends Entity
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
        'ip_range_start' => true,
        'ip_range_end' => true,
        'note' => true,
        'created' => true,
        'modified' => true,
        'is_active' => true,
    ];
}
