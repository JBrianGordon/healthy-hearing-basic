<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Draft Entity
 *
 * @property string $id
 * @property string|null $model_id
 * @property string|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string $json
 *
 * @property \App\Model\Entity\Model $model
 * @property \App\Model\Entity\User $user
 */
class Draft extends Entity
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
        'model' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'json' => true,
        'user' => true,
    ];
}
