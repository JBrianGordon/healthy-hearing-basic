<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Wiki Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $user_id
 * @property string|null $body
 * @property string|null $short
 * @property bool $is_active
 * @property int $id_draft_parent
 * @property int $priority
 * @property string $title_head
 * @property string $title_h1
 * @property string|null $background_file
 * @property string|null $meta_description
 * @property string|null $facebook_title
 * @property string|null $facebook_image
 * @property bool|null $facebook_image_bypass
 * @property int $facebook_image_width
 * @property int $facebook_image_height
 * @property string|null $facebook_image_alt
 * @property string|null $facebook_description
 * @property \Cake\I18n\FrozenTime|null $last_modified
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string $background_alt
 *
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\TagWiki[] $tag_wikis
 * @property-read array $hh_url
 */
class Wiki extends Entity
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
        'slug' => true,
        'user_id' => true,
        'body' => true,
        'short' => true,
        'is_active' => true,
        'id_draft_parent' => true,
        'priority' => true,
        'title_head' => true,
        'title_h1' => true,
        'background_file' => true,
        'meta_description' => true,
        'facebook_title' => true,
        'facebook_image' => true,
        'facebook_image_bypass' => true,
        'facebook_image_width' => true,
        'facebook_image_height' => true,
        'facebook_image_alt' => true,
        'facebook_description' => true,
        'last_modified' => true,
        'modified' => true,
        'created' => true,
        'background_alt' => true,
        'users' => true,
        'tags' => true,
        'contributors' => true,
        'reviewers' => true,
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
            'controller' => 'Wikis',
            'action' => 'view',
            'slug' => $this->slug,
            'plugin' => false,
            'prefix' => false,
        ];
    }
}
