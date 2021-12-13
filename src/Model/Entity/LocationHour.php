<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationHour Entity
 *
 * @property int $id
 * @property int $location_id
 * @property string $sun_open
 * @property string $sun_close
 * @property bool $sun_is_closed
 * @property bool $sun_is_byappt
 * @property string $mon_open
 * @property string $mon_close
 * @property bool $mon_is_closed
 * @property bool $mon_is_byappt
 * @property string $tue_open
 * @property string $tue_close
 * @property bool $tue_is_closed
 * @property bool $tue_is_byappt
 * @property string $wed_open
 * @property string $wed_close
 * @property bool $wed_is_closed
 * @property bool $wed_is_byappt
 * @property string $thu_open
 * @property string $thu_close
 * @property bool $thu_is_closed
 * @property bool $thu_is_byappt
 * @property string $fri_open
 * @property string $fri_close
 * @property bool $fri_is_closed
 * @property bool $fri_is_byappt
 * @property string $sat_open
 * @property string $sat_close
 * @property bool $sat_is_closed
 * @property bool $sat_is_byappt
 * @property bool $is_evening_weekend_hours
 * @property bool $is_closed_lunch
 * @property string $lunch_start
 * @property string $lunch_end
 *
 * @property \App\Model\Entity\Location $location
 */
class LocationHour extends Entity
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
        'location_id' => true,
        'sun_open' => true,
        'sun_close' => true,
        'sun_is_closed' => true,
        'sun_is_byappt' => true,
        'mon_open' => true,
        'mon_close' => true,
        'mon_is_closed' => true,
        'mon_is_byappt' => true,
        'tue_open' => true,
        'tue_close' => true,
        'tue_is_closed' => true,
        'tue_is_byappt' => true,
        'wed_open' => true,
        'wed_close' => true,
        'wed_is_closed' => true,
        'wed_is_byappt' => true,
        'thu_open' => true,
        'thu_close' => true,
        'thu_is_closed' => true,
        'thu_is_byappt' => true,
        'fri_open' => true,
        'fri_close' => true,
        'fri_is_closed' => true,
        'fri_is_byappt' => true,
        'sat_open' => true,
        'sat_close' => true,
        'sat_is_closed' => true,
        'sat_is_byappt' => true,
        'is_evening_weekend_hours' => true,
        'is_closed_lunch' => true,
        'lunch_start' => true,
        'lunch_end' => true,
        'location' => true,
    ];
}
