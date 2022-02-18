<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Corp Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $type
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $last_modified
 * @property int $modified_by
 * @property string $title
 * @property string $title_long
 * @property string $slug
 * @property string $abbr
 * @property string|null $short
 * @property string|null $description
 * @property string|null $notify_email
 * @property string|null $approval_email
 * @property string|null $phone
 * @property string $website_url
 * @property string|null $website_url_description
 * @property string|null $pdf_all_url
 * @property string|null $favicon
 * @property string|null $address
 * @property string|null $thumb_url
 * @property string|null $facebook_title
 * @property string|null $facebook_description
 * @property string|null $facebook_image
 * @property \Cake\I18n\FrozenTime|null $date_approved
 * @property int $id_old
 * @property int $is_approvalrequired
 * @property bool $is_active
 * @property bool $is_featured
 * @property int $id_draft_parent
 * @property string|null $wbc_config
 * @property int $priority
 *
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Advertisement[] $advertisements
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
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'type' => true,
        'created' => true,
        'modified' => true,
        'last_modified' => true,
        'modified_by' => true,
        'title' => true,
        'title_long' => true,
        'slug' => true,
        'abbr' => true,
        'short' => true,
        'description' => true,
        'notify_email' => true,
        'approval_email' => true,
        'phone' => true,
        'website_url' => true,
        'website_url_description' => true,
        'pdf_all_url' => true,
        'favicon' => true,
        'address' => true,
        'thumb_url' => true,
        'facebook_title' => true,
        'facebook_description' => true,
        'facebook_image' => true,
        'date_approved' => true,
        'id_old' => true,
        'is_approvalrequired' => true,
        'is_active' => true,
        'is_featured' => true,
        'id_draft_parent' => true,
        'wbc_config' => true,
        'priority' => true,
        'users' => true,
        'advertisements' => true,
    ];

    protected $_virtual = ['hh_url'];

    protected function _getHhUrl()
    {
        return [
            'controller' => 'Corps',
            'action' => 'view',
            'slug' => $this->slug,
        ];
    }
}