<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CsCallsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CsCallsTable Test Case
 */
class CsCallsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CsCallsTable
     */
    protected $CsCalls;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CsCalls',
        'app.Calls',
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
        $config = $this->getTableLocator()->exists('CsCalls') ? [] : ['className' => CsCallsTable::class];
        $this->CsCalls = $this->getTableLocator()->get('CsCalls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CsCalls);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CsCallsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CsCallsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
