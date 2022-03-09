<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IcingVersion Entity
 *
 * @property string $id
 * @property string $model_id
 * @property int|null $user_id
 * @property string|null $json
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $url
 * @property string|null $ip
 * @property bool $is_delete
 *
 * @property \App\Model\Entity\Model $model
 * @property \App\Model\Entity\User $user
 */
class IcingVersion extends Entity
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
        'model_id' => true,
        'user_id' => true,
        'model' => true,
        'json' => true,
        'created' => true,
        'url' => true,
        'ip' => true,
        'is_delete' => true,
        'user' => true,
    ];
}
