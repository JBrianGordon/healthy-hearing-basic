<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IcingVersionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IcingVersionsTable Test Case
 */
class IcingVersionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IcingVersionsTable
     */
    protected $IcingVersions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.IcingVersions',
        'app.Models',
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
        $config = $this->getTableLocator()->exists('IcingVersions') ? [] : ['className' => IcingVersionsTable::class];
        $this->IcingVersions = $this->getTableLocator()->get('IcingVersions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->IcingVersions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\IcingVersionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\IcingVersionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
