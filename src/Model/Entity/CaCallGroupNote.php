<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CaCallGroupNote Entity
 *
 * @property int $id
 * @property int $ca_call_group_id
 * @property string|null $body
 * @property string|null $status
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\CaCallGroup $ca_call_group
 * @property \App\Model\Entity\User $user
 */
class CaCallGroupNote extends Entity
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
        'ca_call_group_id' => true,
        'body' => true,
        'status' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'ca_call_group' => true,
        'user' => true,
    ];
}
