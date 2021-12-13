<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoHoneypotVisitsFixture
 */
class SeoHoneypotVisitsFixture extends TestFixture
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
                'ip' => 1,
                'created' => '2021-12-10 21:24:14',
            ],
        ];
        parent::init();
    }
}
