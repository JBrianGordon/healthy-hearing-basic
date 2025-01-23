<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Clinic;

use App\Controller\Clinic\LocationsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Clinic\LocationsController Test Case
 *
 * @uses \App\Controller\Clinic\LocationsController
 */
class LocationsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Locations',
        'app.CaCallGroups',
        'app.CallSources',
        'app.CsCalls',
        'app.ImportLocations',
        'app.ImportStatus',
        'app.LocationAds',
        'app.LocationEmails',
        'app.LocationHours',
        'app.LocationLinks',
        'app.LocationNotes',
        'app.LocationPhotos',
        'app.LocationsProviders',
        'app.LocationsUsers',
        'app.Reviews',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Clinic\LocationsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Clinic\LocationsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Clinic\LocationsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Clinic\LocationsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Clinic\LocationsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
