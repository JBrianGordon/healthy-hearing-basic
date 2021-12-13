<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CrmSearchesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CrmSearchesTable Test Case
 */
class CrmSearchesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CrmSearchesTable
     */
    protected $CrmSearches;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CrmSearches',
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
        $config = $this->getTableLocator()->exists('CrmSearches') ? [] : ['className' => CrmSearchesTable::class];
        $this->CrmSearches = $this->getTableLocator()->get('CrmSearches', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CrmSearches);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CrmSearchesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CrmSearchesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
