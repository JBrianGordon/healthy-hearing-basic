<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WikisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WikisTable Test Case
 */
class WikisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WikisTable
     */
    protected $Wikis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Wikis',
        'app.Users',
        'app.ConsumerGuides',
        'app.TagWikis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Wikis') ? [] : ['className' => WikisTable::class];
        $this->Wikis = $this->getTableLocator()->get('Wikis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Wikis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WikisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WikisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
