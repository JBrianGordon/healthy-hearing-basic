<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use CakeDC\Users\Model\Entity\User as CakeDcUser;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $level
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $degrees
 * @property string|null $credentials
 * @property string|null $title_dept_company
 * @property string|null $company
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $country
 * @property string|null $url
 * @property string|null $bio
 * @property string|null $image_url
 * @property string|null $thumb_url
 * @property string|null $square_url
 * @property string|null $micro_url
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $modified_by
 * @property \Cake\I18n\FrozenTime|null $lastlogin
 * @property bool $is_active
 * @property bool $is_hardened_password
 * @property bool $is_admin
 * @property bool $is_it_admin
 * @property bool $is_agent
 * @property bool $is_call_supervisor
 * @property bool $is_author
 * @property string|null $notes
 * @property int|null $corp_id
 * @property bool $is_deleted
 * @property bool $is_csa
 * @property bool $is_writer
 * @property string|null $recovery_email
 * @property string|null $clinic_password
 * @property int $timezone_offset
 * @property string|null $timezone
 *
 * @property \App\Model\Entity\Corp[] $corps
 * @property \App\Model\Entity\CaCallGroupNote[] $ca_call_group_notes
 * @property \App\Model\Entity\CaCall[] $ca_calls
 * @property \App\Model\Entity\Content[] $content
 * @property \App\Model\Entity\CrmSearch[] $crm_searches
 * @property \App\Model\Entity\Draft[] $drafts
 * @property \App\Model\Entity\IcingVersion[] $icing_versions
 * @property \App\Model\Entity\LocationNote[] $location_notes
 * @property \App\Model\Entity\Page[] $pages
 * @property \App\Model\Entity\QueueTaskLog[] $queue_task_logs
 * @property \App\Model\Entity\QueueTask[] $queue_tasks
 * @property \App\Model\Entity\Wiki[] $wikis
 */
class User extends CakeDcUser
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
        'username' => true,
        'password' => true,
        'level' => true,
        'first_name' => true,
        'middle_name' => true,
        'last_name' => true,
        'degrees' => true,
        'credentials' => true,
        'title_dept_company' => true,
        'company' => true,
        'email' => true,
        'phone' => true,
        'address' => true,
        'address_2' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'country' => true,
        'url' => true,
        'bio' => true,
        'image_url' => true,
        'thumb_url' => true,
        'square_url' => true,
        'micro_url' => true,
        'created' => true,
        'modified' => true,
        'modified_by' => true,
        'lastlogin' => true,
        'is_active' => true,
        'is_hardened_password' => true,
        'is_admin' => true,
        'is_it_admin' => true,
        'is_agent' => true,
        'is_call_supervisor' => true,
        'is_author' => true,
        'notes' => true,
        'corp_id' => true,
        'is_deleted' => true,
        'is_csa' => true,
        'is_writer' => true,
        'recovery_email' => true,
        'clinic_password' => true,
        'timezone_offset' => true,
        'timezone' => true,
        'corps' => true,
        'ca_call_group_notes' => true,
        'ca_calls' => true,
        'content' => true,
        'crm_searches' => true,
        'drafts' => true,
        'icing_versions' => true,
        'location_notes' => true,
        'pages' => true,
        'queue_task_logs' => true,
        'queue_tasks' => true,
        'wikis' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected $_virtual = [
        'full_name',
        'full_personal_info'
    ];

    /**
     * Get full name of User
     *
     * @return string Full name of user
     */
    protected function _getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get all information about a User
     * to include full name, degrees, credentials,
     * job title, and company
     *
     * @return string Full personal information for User
     */
    protected function _getFullPersonalInfo()
    {
        $fullPersonalInfo = array_filter([
            $this->full_name,
            $this->degrees,
            $this->credentials,
            $this->title_dept_company,
            $this->company,
        ], 'strlen');

        return implode(', ', $fullPersonalInfo);
    }
}
