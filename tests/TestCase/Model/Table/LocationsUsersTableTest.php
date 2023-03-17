<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationsUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationsUsersTable Test Case
 */
class LocationsUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationsUsersTable
     */
    protected $LocationsUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.LocationsUsers',
        'app.Locations',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationsUsers') ? [] : ['className' => LocationsUsersTable::class];
        $this->LocationsUsers = $this->getTableLocator()->get('LocationsUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LocationsUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationsUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationsUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
