<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentTag Entity
 *
 * @property int $id
 * @property int $content_id
 * @property int $tag_id
 *
 * @property \App\Model\Entity\Content $content
 * @property \App\Model\Entity\Tag $tag
 */
class ContentTag extends Entity
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
        'content_id' => true,
        'tag_id' => true,
        'content' => true,
        'tag' => true,
    ];
}
