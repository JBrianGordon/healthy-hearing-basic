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
 * @property string $title
 * @property string|null $image_name
 * @property string|null $image_url
 * @property string $type
 * @property string $src
 * @property string $public_url
 * @property string $dest
 * @property string $slot
 * @property string $height
 * @property string $width
 * @property string $alt
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
     * @var array
     */
    protected $_accessible = [
        'created' => true,
        'modified' => true,
        'title' => true,
        'image_name' => true,
        'image_url' => true,
        'type' => true,
        'src' => true,
        'public_url' => true,
        'dest' => true,
        'slot' => true,
        'height' => true,
        'width' => true,
        'alt' => true,
        'tags' => true,
        'is_active' => true,
        'tag_corps' => true,
        'tag_basic' => true,
        'corp' => true,
    ];
}
