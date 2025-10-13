<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoUrlsFixture
 */
class SeoUrlsFixture extends TestFixture
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
                'url' => 'Lorem ipsum dolor sit amet',
                'redirect_url' => 'Lorem ipsum dolor sit amet',
                'redirect_is_active' => 1,
                'seo_title' => 'Lorem ipsum dolor sit amet',
                'seo_meta_description' => 'Lorem ipsum dolor sit amet',
                'status_code' => 1,
            ],
        ];
        parent::init();
    }
}
