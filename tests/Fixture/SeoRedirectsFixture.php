<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoRedirectsFixture
 */
class SeoRedirectsFixture extends TestFixture
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
                'redirect' => 'Lorem ipsum dolor sit amet',
                'priority' => 1,
                'is_active' => 1,
                'callback' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-10 21:24:14',
                'modified' => '2021-12-10 21:24:14',
                'is_nocache' => 1,
            ],
        ];
        parent::init();
    }
}
