<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoTitle Entity
 *
 * @property int $id
 * @property int $seo_uri_id
 * @property string $title
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\SeoUri $seo_uri
 */
class SeoTitle extends Entity
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
        'seo_uri_id' => true,
        'title' => true,
        'created' => true,
        'modified' => true,
        'seo_uri' => true,
    ];
}
