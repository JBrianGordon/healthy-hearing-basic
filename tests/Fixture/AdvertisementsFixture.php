<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdvertisementsFixture
 */
class AdvertisementsFixture extends TestFixture
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
                'created' => '2021-12-10 21:23:53',
                'modified' => '2021-12-10 21:23:53',
                'modified_by' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'slug' => 'Lorem ipsum dolor sit amet',
                'corp_id' => 1,
                'type' => 'Lorem ',
                'src' => 'Lorem ipsum dolor sit amet',
                'dest' => 'Lorem ipsum dolor sit amet',
                'slot' => 'Lorem ipsum dolor sit amet',
                'height' => 'Lorem ipsum dolor sit amet',
                'width' => 'Lorem ipsum dolor sit amet',
                'alt' => 'Lorem ipsum dolor sit amet',
                'class' => 'Lorem ipsum dolor sit amet',
                'style' => 'Lorem ipsum dolor sit amet',
                'onclick' => 'Lorem ipsum dolor sit amet',
                'onmouseover' => 'Lorem ipsum dolor sit amet',
                'weight' => 1,
                'active_expires' => '2021-12-10',
                'restrict_path' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_ao' => 1,
                'is_hh' => 1,
                'is_sp' => 1,
                'is_ei' => 1,
                'is_active' => 1,
                'tag_corps' => 1,
                'tag_basic' => 1,
            ],
        ];
        parent::init();
    }
}
