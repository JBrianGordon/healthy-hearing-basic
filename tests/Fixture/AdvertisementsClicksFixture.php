<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdvertisementsClicksFixture
 */
class AdvertisementsClicksFixture extends TestFixture
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
                'created' => '2021-12-10 21:23:54',
                'ad_id' => 1,
                'ref' => 'Lorem ipsum dolor sit amet',
                'ip' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
