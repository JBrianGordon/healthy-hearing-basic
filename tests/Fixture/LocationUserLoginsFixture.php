<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationUserLoginsFixture
 */
class LocationUserLoginsFixture extends TestFixture
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
                'location_user_id' => 1,
                'login_date' => '2021-12-10 21:24:07',
                'ip' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
