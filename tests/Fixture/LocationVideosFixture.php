<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationVideosFixture
 */
class LocationVideosFixture extends TestFixture
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
                'video_url' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-10 21:24:08',
                'modified' => '2021-12-10 21:24:08',
            ],
        ];
        parent::init();
    }
}
