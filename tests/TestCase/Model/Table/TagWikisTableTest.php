<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TagWikisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TagWikisTable Test Case
 */
class TagWikisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TagWikisTable
     */
    protected $TagWikis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TagWikis',
        'app.Wikis',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TagWikis') ? [] : ['className' => TagWikisTable::class];
        $this->TagWikis = $this->getTableLocator()->get('TagWikis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TagWikis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TagWikisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TagWikisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
