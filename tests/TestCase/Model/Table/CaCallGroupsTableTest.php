<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CaCallGroupsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CaCallGroupsTable Test Case
 */
class CaCallGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CaCallGroupsTable
     */
    protected $CaCallGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CaCallGroups',
        'app.Locations',
        'app.CaCallGroupNotes',
        'app.CaCalls',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CaCallGroups') ? [] : ['className' => CaCallGroupsTable::class];
        $this->CaCallGroups = $this->getTableLocator()->get('CaCallGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CaCallGroups);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CaCallGroupsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CaCallGroupsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
