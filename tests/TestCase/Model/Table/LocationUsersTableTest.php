<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationUsersTable Test Case
 */
class LocationUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationUsersTable
     */
    protected $LocationUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationUsers',
        'app.Locations',
        'app.LocationUserLogins',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationUsers') ? [] : ['className' => LocationUsersTable::class];
        $this->LocationUsers = $this->getTableLocator()->get('LocationUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
