<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Content Entity
 *
 * @property int $id
 * @property int|null $id_brafton
 * @property int|null $user_id
 * @property string $type
 * @property \Cake\I18n\FrozenDate|null $date
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $last_modified
 * @property string $title
 * @property string $alt_title
 * @property string|null $subtitle
 * @property string $title_head
 * @property string $slug
 * @property string $short
 * @property string $body
 * @property string $meta_description
 * @property string $bodyclass
 * @property bool $is_active
 * @property bool $is_library_item
 * @property string $library_share_text
 * @property bool $is_gone
 * @property string|null $facebook_title
 * @property string|null $facebook_description
 * @property string|null $facebook_image
 * @property string|null $facebook_image_name
 * @property string|null $facebook_image_url
 * @property int $facebook_image_width
 * @property bool|null $facebook_image_width_override
 * @property int $facebook_image_height
 * @property string|null $facebook_image_alt
 * @property bool $old_url
 * @property int $id_draft_parent
 * @property bool|null $is_frozen
 *
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Tag[] $tags
 * @property-read array $hh_url
 */
class Content extends Entity
{
    static $typeOptions = array(
        'article'   =>  'Articles',
        'faq'       =>  'FAQs',
        'interview' =>  'Interviews',
        'news'      =>  'News',
        'hearingcenterint' => 'HearingCenterInts',
    );

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
        'id_brafton' => true,
        'user_id' => true,
        'type' => true,
        'date' => true,
        'created' => true,
        'modified' => true,
        'last_modified' => true,
        'title' => true,
        'alt_title' => true,
        'subtitle' => true,
        'title_head' => true,
        'slug' => true,
        'short' => true,
        'body' => true,
        'meta_description' => true,
        'bodyclass' => true,
        'is_active' => true,
        'is_library_item' => true,
        'library_share_text' => true,
        'is_gone' => true,
        'facebook_title' => true,
        'facebook_description' => true,
        'facebook_image' => true,
        'facebook_image_name' => true,
        'facebook_image_url' => true,
        'facebook_image_width' => true,
        'facebook_image_width_override' => true,
        'facebook_image_height' => true,
        'facebook_image_alt' => true,
        'old_url' => true,
        'id_draft_parent' => true,
        'is_frozen' => true,
        'users' => true,
        'tags' => true,
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
            'controller' => 'Content',
            'action' => 'view',
            'id' => $this->id,
            'slug' => $this->slug,
            'plugin' => false,
            'prefix' => false,
        ];
    }
}
