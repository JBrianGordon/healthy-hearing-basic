<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Corp Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $last_modified
 * @property int $modified_by
 * @property string $title
 * @property string $slug
 * @property string|null $short
 * @property string|null $description
 * @property string|null $thumb_url
 * @property string|null $facebook_title
 * @property string|null $facebook_description
 * @property string|null $facebook_image
 * @property bool $is_active
 * @property int $id_draft_parent
 * @property int $priority
 *
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Advertisement[] $advertisements
 * @property-read array $hh_url
 */
class Corp extends Entity
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
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'last_modified' => true,
        'modified_by' => true,
        'title' => true,
        'slug' => true,
        'short' => true,
        'description' => true,
        'logo_name' => true,
        'logo_url' => true,
        'thumb_url' => true,
        'facebook_title' => true,
        'facebook_description' => true,
        'facebook_image_name' => true,
        'facebook_image_url' => true,
        'facebook_image' => true,
        'is_active' => true,
        'id_draft_parent' => true,
        'priority' => true,
        'users' => true,
        'advertisements' => true,
        'contributors' => true,
    ];

    protected $_virtual = ['hh_url'];

    /**
     * Generate routing array for 'HH URL'
     *
     * @return array CakePHP routing array
     */
    protected function _getHhUrl()
    {
        return [
            'controller' => 'Corps',
            'action' => 'view',
            'slug' => $this->slug,
            'plugin' => false,
            'prefix' => false,
        ];
    }
}
