<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationUserLoginsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationUserLoginsTable Test Case
 */
class LocationUserLoginsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationUserLoginsTable
     */
    protected $LocationUserLogins;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationUserLogins',
        'app.LocationUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationUserLogins') ? [] : ['className' => LocationUserLoginsTable::class];
        $this->LocationUserLogins = $this->getTableLocator()->get('LocationUserLogins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationUserLogins);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationUserLoginsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationUserLoginsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
