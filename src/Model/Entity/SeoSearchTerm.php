<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoSearchTerm Entity
 *
 * @property int $id
 * @property string $term
 * @property string $uri
 * @property int $count
 * @property \Cake\I18n\FrozenTime|null $created
 */
class SeoSearchTerm extends Entity
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
        'term' => true,
        'uri' => true,
        'count' => true,
        'created' => true,
    ];
}
