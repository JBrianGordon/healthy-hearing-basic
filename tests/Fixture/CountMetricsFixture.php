<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountMetricsFixture
 */
class CountMetricsFixture extends TestFixture
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
                'id' => '93bfde9a-8f9e-4089-9b11-0a2e6a0b2113',
                'type' => 'Lorem ipsum do',
                'metric' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'sub_name' => 'Lorem ipsum dolor sit amet',
                'count' => 1,
                'updated' => 1639171439,
                'created' => 1639171439,
            ],
        ];
        parent::init();
    }
}
