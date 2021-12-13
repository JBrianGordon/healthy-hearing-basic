<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ZipcodesFixture
 */
class ZipcodesFixture extends TestFixture
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
                'zip' => 'd3fe29f9-b954-4ccb-8be6-7361f367b4a2',
                'lat' => 1,
                'lon' => 1,
                'city' => '',
                'state' => '',
                'areacode' => 'L',
                'country_code' => 'Lo',
            ],
        ];
        parent::init();
    }
}
