<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CrmSearch Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $model
 * @property string $title
 * @property string|null $search
 * @property bool $is_public
 * @property int $priority
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 */
class CrmSearch extends Entity
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
        'model' => true,
        'title' => true,
        'search' => true,
        'is_public' => true,
        'priority' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
