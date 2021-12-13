<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportStatusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportStatusTable Test Case
 */
class ImportStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportStatusTable
     */
    protected $ImportStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ImportStatus',
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
        $config = $this->getTableLocator()->exists('ImportStatus') ? [] : ['className' => ImportStatusTable::class];
        $this->ImportStatus = $this->getTableLocator()->get('ImportStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ImportStatus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ImportStatusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ImportStatusTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
