<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportDiffsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportDiffsTable Test Case
 */
class ImportDiffsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportDiffsTable
     */
    protected $ImportDiffs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ImportDiffs',
        'app.Imports',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ImportDiffs') ? [] : ['className' => ImportDiffsTable::class];
        $this->ImportDiffs = $this->getTableLocator()->get('ImportDiffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ImportDiffs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ImportDiffsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ImportDiffsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
