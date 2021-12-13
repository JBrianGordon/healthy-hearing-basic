<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * City Entity
 *
 * @property int $id
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property float $lon
 * @property float $lat
 * @property int $population
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $is_near_location
 * @property bool $is_featured
 */
class City extends Entity
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
        'city' => true,
        'state' => true,
        'zip' => true,
        'country' => true,
        'lon' => true,
        'lat' => true,
        'population' => true,
        'created' => true,
        'modified' => true,
        'is_near_location' => true,
        'is_featured' => true,
    ];
}
