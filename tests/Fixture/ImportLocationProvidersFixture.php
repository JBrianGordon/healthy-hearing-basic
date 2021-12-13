<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ImportLocationProvidersFixture
 */
class ImportLocationProvidersFixture extends TestFixture
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
                'import_id' => 1,
                'import_location_id' => 1,
                'import_provider_id' => 1,
            ],
        ];
        parent::init();
    }
}
