<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationProvidersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationProvidersTable Test Case
 */
class LocationProvidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationProvidersTable
     */
    protected $LocationProviders;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationProviders',
        'app.Locations',
        'app.Providers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationProviders') ? [] : ['className' => LocationProvidersTable::class];
        $this->LocationProviders = $this->getTableLocator()->get('LocationProviders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationProviders);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationProvidersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationProvidersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
