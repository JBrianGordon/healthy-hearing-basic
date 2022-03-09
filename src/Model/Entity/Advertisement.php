<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Advertisement Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $modified_by
 * @property string $title
 * @property string $slug
 * @property int $corp_id
 * @property string $type
 * @property string $src
 * @property string $dest
 * @property string $slot
 * @property string $height
 * @property string $width
 * @property string $alt
 * @property string $class
 * @property string $style
 * @property string $onclick
 * @property string $onmouseover
 * @property int $weight
 * @property \Cake\I18n\FrozenDate|null $active_expires
 * @property string|null $restrict_path
 * @property string|null $notes
 * @property bool $is_ao
 * @property bool $is_hh
 * @property bool $is_sp
 * @property bool $is_ei
 * @property bool $is_active
 * @property bool $tag_corps
 * @property bool $tag_basic
 *
 * @property \App\Model\Entity\Corp $corp
 */
class Advertisement extends Entity
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
        'created' => true,
        'modified' => true,
        'modified_by' => true,
        'title' => true,
        'slug' => true,
        'corp_id' => true,
        'type' => true,
        'src' => true,
        'dest' => true,
        'slot' => true,
        'height' => true,
        'width' => true,
        'alt' => true,
        'class' => true,
        'style' => true,
        'onclick' => true,
        'onmouseover' => true,
        'weight' => true,
        'active_expires' => true,
        'restrict_path' => true,
        'notes' => true,
        'is_ao' => true,
        'is_hh' => true,
        'is_sp' => true,
        'is_ei' => true,
        'is_active' => true,
        'tag_corps' => true,
        'tag_basic' => true,
        'corp' => true,
    ];
}
