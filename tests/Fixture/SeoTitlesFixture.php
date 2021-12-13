<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoTitlesFixture
 */
class SeoTitlesFixture extends TestFixture
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
                'title' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-10 21:24:16',
                'modified' => '2021-12-10 21:24:16',
            ],
        ];
        parent::init();
    }
}
