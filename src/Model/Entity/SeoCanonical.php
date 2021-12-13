<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoCanonical Entity
 *
 * @property int $id
 * @property int $seo_uri_id
 * @property string $canonical
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\SeoUri $seo_uri
 */
class SeoCanonical extends Entity
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
        'seo_uri_id' => true,
        'canonical' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'seo_uri' => true,
    ];
}
