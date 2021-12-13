<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SitemapUrlsFixture
 */
class SitemapUrlsFixture extends TestFixture
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
                'model' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'priority' => 1,
                'created' => '2021-12-10 21:24:17',
                'modified' => '2021-12-10 21:24:17',
            ],
        ];
        parent::init();
    }
}
