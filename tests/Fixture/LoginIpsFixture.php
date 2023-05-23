<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoginIpsFixture
 */
class LoginIpsFixture extends TestFixture
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
                'user_id' => 1,
                'location_user_id' => 1,
                'login_date' => '2023-05-12 21:03:41',
                'ip' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
