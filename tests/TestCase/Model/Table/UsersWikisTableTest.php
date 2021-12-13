<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersWikisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersWikisTable Test Case
 */
class UsersWikisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersWikisTable
     */
    protected $UsersWikis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UsersWikis',
        'app.Wikis',
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
        $config = $this->getTableLocator()->exists('UsersWikis') ? [] : ['className' => UsersWikisTable::class];
        $this->UsersWikis = $this->getTableLocator()->get('UsersWikis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UsersWikis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UsersWikisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UsersWikisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
