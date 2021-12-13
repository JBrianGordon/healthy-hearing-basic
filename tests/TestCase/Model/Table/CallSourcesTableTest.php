<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CallSourcesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CallSourcesTable Test Case
 */
class CallSourcesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CallSourcesTable
     */
    protected $CallSources;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CallSources',
        'app.Locations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CallSources') ? [] : ['className' => CallSourcesTable::class];
        $this->CallSources = $this->getTableLocator()->get('CallSources', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CallSources);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CallSourcesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CallSourcesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
