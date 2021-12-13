<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QueueTasksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QueueTasksTable Test Case
 */
class QueueTasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QueueTasksTable
     */
    protected $QueueTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.QueueTasks',
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
        $config = $this->getTableLocator()->exists('QueueTasks') ? [] : ['className' => QueueTasksTable::class];
        $this->QueueTasks = $this->getTableLocator()->get('QueueTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->QueueTasks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\QueueTasksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\QueueTasksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
