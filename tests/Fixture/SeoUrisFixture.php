<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoUrisFixture
 */
class SeoUrisFixture extends TestFixture
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
                'uri' => 'Lorem ipsum dolor sit amet',
                'is_approved' => 1,
                'created' => '2021-12-10 21:24:16',
                'modified' => '2021-12-10 21:24:16',
            ],
        ];
        parent::init();
    }
}
