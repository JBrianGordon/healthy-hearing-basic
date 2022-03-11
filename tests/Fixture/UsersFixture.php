<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'level' => 1,
                'first_name' => 'Jane',
                'middle_name' => '',
                'last_name' => 'Smith',
                'degrees' => 'Lorem ipsum dolor sit amet',
                'credentials' => 'Lorem ipsum dolor sit amet',
                'title_dept_company' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'company' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'address_2' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => 'Lorem ipsum dolor sit amet',
                'zip' => 'Lorem ipsum dolor sit amet',
                'country' => 'Lo',
                'url' => 'Lorem ipsum dolor sit amet',
                'bio' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'image_url' => 'Lorem ipsum dolor sit amet',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'square_url' => 'Lorem ipsum dolor sit amet',
                'micro_url' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-10 21:24:19',
                'modified' => '2021-12-10 21:24:19',
                'modified_by' => 1,
                'lastlogin' => '2021-12-10 21:24:19',
                'is_active' => 1,
                'is_hardened_password' => 1,
                'is_admin' => 1,
                'is_it_admin' => 1,
                'is_agent' => 1,
                'is_call_supervisor' => 1,
                'is_author' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'corp_id' => 1,
                'is_deleted' => 1,
                'is_csa' => 1,
                'is_writer' => 1,
                'recovery_email' => 'Lorem ipsum dolor sit amet',
                'clinic_password' => 'Lorem ip',
                'timezone_offset' => 1,
                'timezone' => 'L',
            ],
        ];
        parent::init();
    }
}
