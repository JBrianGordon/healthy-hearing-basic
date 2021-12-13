<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QueueTaskLogsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QueueTaskLogsTable Test Case
 */
class QueueTaskLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QueueTaskLogsTable
     */
    protected $QueueTaskLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.QueueTaskLogs',
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
        $config = $this->getTableLocator()->exists('QueueTaskLogs') ? [] : ['className' => QueueTaskLogsTable::class];
        $this->QueueTaskLogs = $this->getTableLocator()->get('QueueTaskLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->QueueTaskLogs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\QueueTaskLogsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\QueueTaskLogsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
