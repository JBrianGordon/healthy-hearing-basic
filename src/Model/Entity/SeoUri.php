<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoUri Entity
 *
 * @property int $id
 * @property string|null $uri
 * @property bool $is_approved
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\SeoCanonical[] $seo_canonicals
 * @property \App\Model\Entity\SeoMetaTag[] $seo_meta_tags
 * @property \App\Model\Entity\SeoRedirect[] $seo_redirects
 * @property \App\Model\Entity\SeoStatusCode[] $seo_status_codes
 * @property \App\Model\Entity\SeoTitle[] $seo_titles
 */
class SeoUri extends Entity
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
        'uri' => true,
        'is_approved' => true,
        'created' => true,
        'modified' => true,
        'seo_canonicals' => true,
        'seo_meta_tags' => true,
        'seo_redirects' => true,
        'seo_status_codes' => true,
        'seo_titles' => true,
    ];
}
