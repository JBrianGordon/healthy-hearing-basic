<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tag Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $is_category
 * @property bool $is_sub_category
 * @property string|null $header
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string $display_header
 * @property string $ribbon_header
 *
 * @property \App\Model\Entity\TagAd[] $tag_ads
 * @property \App\Model\Entity\TagWiki[] $tag_wikis
 * @property \App\Model\Entity\Content[] $content
 */
class Tag extends Entity
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
        'name' => true,
        'is_category' => true,
        'is_sub_category' => true,
        'header' => true,
        'created' => true,
        'modified' => true,
        'display_header' => true,
        'ribbon_header' => true,
        'tag_ads' => true,
        'tag_wikis' => true,
        'content' => true,
    ];
}
