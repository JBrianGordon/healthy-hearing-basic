<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoStatusCodesFixture
 */
class SeoStatusCodesFixture extends TestFixture
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
                'status_code' => 1,
                'priority' => 1,
                'is_active' => 1,
                'created' => '2021-12-10 21:24:15',
                'modified' => '2021-12-10 21:24:15',
            ],
        ];
        parent::init();
    }
}
