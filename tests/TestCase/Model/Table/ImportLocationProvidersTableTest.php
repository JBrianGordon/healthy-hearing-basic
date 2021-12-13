<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportLocationProvidersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportLocationProvidersTable Test Case
 */
class ImportLocationProvidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportLocationProvidersTable
     */
    protected $ImportLocationProviders;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ImportLocationProviders',
        'app.Imports',
        'app.ImportLocations',
        'app.ImportProviders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ImportLocationProviders') ? [] : ['className' => ImportLocationProvidersTable::class];
        $this->ImportLocationProviders = $this->getTableLocator()->get('ImportLocationProviders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ImportLocationProviders);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ImportLocationProvidersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ImportLocationProvidersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
