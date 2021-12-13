<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ImportStatusFixture
 */
class ImportStatusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'import_status';
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
                'status' => 1,
                'oticon_tier' => 1,
                'listing_type' => 'Lorem ipsum dolor ',
                'is_active' => 1,
                'is_show' => 1,
                'is_grace_period' => 1,
                'created' => '2021-12-10 21:24:03',
            ],
        ];
        parent::init();
    }
}
