<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProvidersFixture
 */
class ProvidersFixture extends TestFixture
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
                'first_name' => 'Lorem ipsum dolor sit amet',
                'middle_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'credentials' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'micro_url' => 'Lorem ipsum dolor sit amet',
                'square_url' => 'Lorem ipsum dolor sit amet',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'image_url' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'created' => '2021-12-10 21:24:10',
                'modified' => '2021-12-10 21:24:10',
                'phone' => 'Lorem ipsum do',
                'priority' => 1,
                'aud_or_his' => 'Lorem ipsum dolor sit amet',
                'is_ida_verified' => 1,
                'id_yhn_provider' => 1,
            ],
        ];
        parent::init();
    }
}
