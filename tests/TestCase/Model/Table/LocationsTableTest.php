<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationsTable Test Case
 */
class LocationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationsTable
     */
    protected $Locations;

    /**
     * Fixtures
     *
     * @var array
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
        'app.LocationProviders',
        'app.LocationsUsers',
        'app.LocationVidscrips',
        'app.Reviews',
        'app.Content',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Locations') ? [] : ['className' => LocationsTable::class];
        $this->Locations = $this->getTableLocator()->get('Locations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Locations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
