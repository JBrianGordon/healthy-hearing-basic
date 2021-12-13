<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ImportsFixture
 */
class ImportsFixture extends TestFixture
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
                'type' => 'Lorem ipsum dolor sit amet',
                'total_locations' => 1,
                'new_locations' => 1,
                'updated_locations' => 1,
                'total_providers' => 1,
                'new_providers' => 1,
                'updated_providers' => 1,
                'created' => '2021-12-10 21:24:04',
            ],
        ];
        parent::init();
    }
}
