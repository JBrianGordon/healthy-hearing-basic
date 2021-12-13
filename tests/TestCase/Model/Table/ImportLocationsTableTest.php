<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportLocationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportLocationsTable Test Case
 */
class ImportLocationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportLocationsTable
     */
    protected $ImportLocations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ImportLocations',
        'app.Imports',
        'app.Locations',
        'app.ImportLocationProviders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ImportLocations') ? [] : ['className' => ImportLocationsTable::class];
        $this->ImportLocations = $this->getTableLocator()->get('ImportLocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ImportLocations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ImportLocationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ImportLocationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
