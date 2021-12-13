<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QueueTask Entity
 *
 * @property string $id
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $executed
 * @property \Cake\I18n\FrozenTime|null $scheduled
 * @property \Cake\I18n\FrozenTime|null $scheduled_end
 * @property string|null $reschedule
 * @property int|null $start_time
 * @property int|null $end_time
 * @property int|null $cpu_limit
 * @property bool $is_restricted
 * @property int $priority
 * @property int $status
 * @property int $type
 * @property string $command
 * @property string|null $result
 *
 * @property \App\Model\Entity\User $user
 */
class QueueTask extends Entity
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
        'created' => true,
        'modified' => true,
        'executed' => true,
        'scheduled' => true,
        'scheduled_end' => true,
        'reschedule' => true,
        'start_time' => true,
        'end_time' => true,
        'cpu_limit' => true,
        'is_restricted' => true,
        'priority' => true,
        'status' => true,
        'type' => true,
        'command' => true,
        'result' => true,
        'user' => true,
    ];
}
