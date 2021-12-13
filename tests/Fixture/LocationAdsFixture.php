<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationAdsFixture
 */
class LocationAdsFixture extends TestFixture
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
                'photo_url' => 'Lorem ipsum dolor sit amet',
                'alt' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'border' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-10 21:24:04',
                'modified' => '2021-12-10 21:24:04',
            ],
        ];
        parent::init();
    }
}
