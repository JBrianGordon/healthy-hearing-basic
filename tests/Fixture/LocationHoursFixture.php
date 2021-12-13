<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationHoursFixture
 */
class LocationHoursFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'location_id' => 1,
                'sun_open' => 'Lorem ipsum dolor sit amet',
                'sun_close' => 'Lorem ipsum dolor sit amet',
                'sun_is_closed' => 1,
                'sun_is_byappt' => 1,
                'mon_open' => 'Lorem ipsum dolor sit amet',
                'mon_close' => 'Lorem ipsum dolor sit amet',
                'mon_is_closed' => 1,
                'mon_is_byappt' => 1,
                'tue_open' => 'Lorem ipsum dolor sit amet',
                'tue_close' => 'Lorem ipsum dolor sit amet',
                'tue_is_closed' => 1,
                'tue_is_byappt' => 1,
                'wed_open' => 'Lorem ipsum dolor sit amet',
                'wed_close' => 'Lorem ipsum dolor sit amet',
                'wed_is_closed' => 1,
                'wed_is_byappt' => 1,
                'thu_open' => 'Lorem ipsum dolor sit amet',
                'thu_close' => 'Lorem ipsum dolor sit amet',
                'thu_is_closed' => 1,
                'thu_is_byappt' => 1,
                'fri_open' => 'Lorem ipsum dolor sit amet',
                'fri_close' => 'Lorem ipsum dolor sit amet',
                'fri_is_closed' => 1,
                'fri_is_byappt' => 1,
                'sat_open' => 'Lorem ipsum dolor sit amet',
                'sat_close' => 'Lorem ipsum dolor sit amet',
                'sat_is_closed' => 1,
                'sat_is_byappt' => 1,
                'is_evening_weekend_hours' => 1,
                'is_closed_lunch' => 1,
                'lunch_start' => 'Lorem ipsum dolor sit amet',
                'lunch_end' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
