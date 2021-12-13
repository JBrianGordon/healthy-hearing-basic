<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CsCallsFixture
 */
class CsCallsFixture extends TestFixture
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
                'call_id' => 1,
                'location_id' => 1,
                'ad_source' => 'Lorem ipsum dolor sit amet',
                'start_time' => '2021-12-10 21:24:00',
                'result' => 'L',
                'duration' => 1,
                'call_type' => 'Lorem ipsum dolor sit amet',
                'call_status' => 'Lorem ipsum dolor sit amet',
                'leadscore' => 'Lorem ipsum dolor sit amet',
                'recording_url' => 'Lorem ipsum dolor sit amet',
                'tracking_number' => 'Lorem ipsum do',
                'caller_phone' => 'Lorem ipsum do',
                'clinic_phone' => 'Lorem ipsum do',
                'caller_firstname' => 'Lorem ipsum dolor sit amet',
                'caller_lastname' => 'Lorem ipsum dolor sit amet',
                'prospect' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
