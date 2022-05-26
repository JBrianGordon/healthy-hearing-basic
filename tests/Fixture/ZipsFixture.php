<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ZipsFixture
 */
class ZipsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'zipcodes';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'zip' => '98801',
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
