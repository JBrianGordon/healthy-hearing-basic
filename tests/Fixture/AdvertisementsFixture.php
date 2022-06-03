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
                'created' => '2022-06-03 16:03:10',
                'modified' => '2022-06-03 16:03:10',
                'title' => 'Lorem ipsum dolor sit amet',
                'type' => 'Lorem ',
                'src' => 'Lorem ipsum dolor sit amet',
                'dest' => 'Lorem ipsum dolor sit amet',
                'slot' => 'Lorem ipsum dolor sit amet',
                'height' => 'Lorem ipsum dolor sit amet',
                'width' => 'Lorem ipsum dolor sit amet',
                'alt' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'tag_corps' => 1,
                'tag_basic' => 1,
            ],
        ];
        parent::init();
    }
}
