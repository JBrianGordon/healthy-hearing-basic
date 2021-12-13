<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoRedirect Entity
 *
 * @property int $id
 * @property int $seo_uri_id
 * @property string|null $redirect
 * @property int $priority
 * @property bool $is_active
 * @property string|null $callback
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool|null $is_nocache
 *
 * @property \App\Model\Entity\SeoUri $seo_uri
 */
class SeoRedirect extends Entity
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
        'redirect' => true,
        'priority' => true,
        'is_active' => true,
        'callback' => true,
        'created' => true,
        'modified' => true,
        'is_nocache' => true,
        'seo_uri' => true,
    ];
}
