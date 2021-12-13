<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationUsersFixture
 */
class LocationUsersFixture extends TestFixture
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
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-10 21:24:08',
                'modified' => '2021-12-10 21:24:08',
                'lastlogin' => '2021-12-10 21:24:08',
                'is_active' => 1,
                'reset_url' => 'Lorem ipsum dolor sit a',
                'reset_expiration_date' => '2021-12-10 21:24:08',
                'clinic_password' => 'Lorem ip',
                'location_id' => 1,
            ],
        ];
        parent::init();
    }
}
