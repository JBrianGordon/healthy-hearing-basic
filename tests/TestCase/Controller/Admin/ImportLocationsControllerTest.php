<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\ImportLocationsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ImportLocationsController Test Case
 *
 * @uses \App\Controller\Admin\ImportLocationsController
 */
class ImportLocationsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ImportLocations',
        'app.Imports',
        'app.Locations',
        'app.ImportLocationProviders',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\ImportLocationsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
