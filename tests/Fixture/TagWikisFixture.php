<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagWikisFixture
 */
class TagWikisFixture extends TestFixture
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
                'wiki_id' => 1,
                'tag_id' => 1,
            ],
        ];
        parent::init();
    }
}
