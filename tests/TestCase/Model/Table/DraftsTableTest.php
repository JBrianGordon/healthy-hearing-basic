<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DraftsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DraftsTable Test Case
 */
class DraftsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DraftsTable
     */
    protected $Drafts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Drafts',
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
        $config = $this->getTableLocator()->exists('Drafts') ? [] : ['className' => DraftsTable::class];
        $this->Drafts = $this->getTableLocator()->get('Drafts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Drafts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DraftsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DraftsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
