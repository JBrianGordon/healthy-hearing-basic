<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Zipcode Entity
 *
 * @property string $zip
 * @property float $lat
 * @property float $lon
 * @property string $city
 * @property string $state
 * @property string $areacode
 * @property string|null $country_code
 */
class Zipcode extends Entity
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
        'lat' => true,
        'lon' => true,
        'city' => true,
        'state' => true,
        'areacode' => true,
        'country_code' => true,
    ];
}
