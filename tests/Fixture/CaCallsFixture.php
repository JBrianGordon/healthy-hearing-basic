<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CaCallsFixture
 */
class CaCallsFixture extends TestFixture
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
                'ca_call_group_id' => 1,
                'user_id' => 1,
                'start_time' => '2021-12-10 21:23:55',
                'duration' => 1,
                'call_type' => 'Lorem ipsum dolor sit amet',
                'recording_url' => 'Lorem ipsum dolor sit amet',
                'recording_duration' => 1,
            ],
        ];
        parent::init();
    }
}
