<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TagAd Entity
 *
 * @property int $id
 * @property int $ad_id
 * @property int $tag_id
 *
 * @property \App\Model\Entity\Ad $ad
 * @property \App\Model\Entity\Tag $tag
 */
class TagAd extends Entity
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
        'ad_id' => true,
        'tag_id' => true,
        'ad' => true,
        'tag' => true,
    ];
}
