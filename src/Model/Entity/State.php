<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * State Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string $body
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class State extends Entity
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
        'name' => true,
        'body' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
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
            'action' => 'viewState',
            'region' => $this->fetchTable('Locations')->stateSlug($this->name),
            'plugin' => false,
            'prefix' => false,
        ];
    }
}