<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CitiesFixture
 */
class CitiesFixture extends TestFixture
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
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => '',
                'country' => '',
                'lon' => 1,
                'lat' => 1,
                'population' => 1,
                'created' => '2021-12-10 21:23:56',
                'modified' => '2021-12-10 21:23:56',
                'is_near_location' => 1,
                'is_featured' => 1,
            ],
        ];
        parent::init();
    }
}
