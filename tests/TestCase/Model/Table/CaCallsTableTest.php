<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CaCallsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CaCallsTable Test Case
 */
class CaCallsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CaCallsTable
     */
    protected $CaCalls;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CaCalls',
        'app.CaCallGroups',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CaCalls') ? [] : ['className' => CaCallsTable::class];
        $this->CaCalls = $this->getTableLocator()->get('CaCalls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CaCalls);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CaCallsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CaCallsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
