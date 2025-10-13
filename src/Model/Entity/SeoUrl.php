<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoUrl Entity
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $redirect_url
 * @property bool $redirect_is_active
 * @property string|null $seo_title
 * @property string|null $seo_meta_description
 * @property int|null $status_code
 */
class SeoUrl extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'url' => true,
        'redirect_url' => true,
        'redirect_is_active' => true,
        'seo_title' => true,
        'seo_meta_description' => true,
        'is_410' => true,
    ];
}
