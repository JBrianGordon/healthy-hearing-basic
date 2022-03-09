<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdvertisementsClick Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $ad_id
 * @property string $ref
 * @property string $ip
 *
 * @property \App\Model\Entity\Ad $ad
 */
class AdvertisementsClick extends Entity
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
        'created' => true,
        'ad_id' => true,
        'ref' => true,
        'ip' => true,
        'ad' => true,
    ];
}
