<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationsProvidersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationsProvidersTable Test Case
 */
class LocationsProvidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationsProvidersTable
     */
    protected $LocationsProviders;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.LocationsProviders',
        'app.Locations',
        'app.Providers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationsProviders') ? [] : ['className' => LocationsProvidersTable::class];
        $this->LocationsProviders = $this->getTableLocator()->get('LocationsProviders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LocationsProviders);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationsProvidersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationsProvidersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
