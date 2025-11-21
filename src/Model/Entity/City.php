<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * City Entity
 *
 * @property int $id
 * @property string $city
 * @property string $state
 * @property string $country
 * @property float $lon
 * @property float $lat
 * @property int $population
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $is_near_location
 * @property bool $is_featured
 * @property-read array $hh_url
 */
class City extends Entity
{
    use LocatorAwareTrait;

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
        'city' => true,
        'state' => true,
        'country' => true,
        'lon' => true,
        'lat' => true,
        'population' => true,
        'created' => true,
        'modified' => true,
        'is_near_location' => true,
        'is_featured' => true,
    ];

    protected $_virtual = ['hh_url'];

    /**
     * Generate routing array for 'HH URL'
     *
     * @return array CakePHP routing array
     */
    protected function _getHhUrl()
    {
        return [
            'controller' => 'Locations',
            'action' => 'viewCityZip',
            'region' => $this->fetchTable('Locations')->stateSlug($this->state),
            'city' => slugifyCity($this->city),
            'plugin' => false,
            'prefix' => false,
        ];
    }
}
