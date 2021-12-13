<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoCanonicalsFixture
 */
class SeoCanonicalsFixture extends TestFixture
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
                'seo_uri_id' => 1,
                'canonical' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'created' => '2021-12-10 21:24:13',
                'modified' => '2021-12-10 21:24:13',
            ],
        ];
        parent::init();
    }
}
