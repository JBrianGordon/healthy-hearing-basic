<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoginIpsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoginIpsTable Test Case
 */
class LoginIpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoginIpsTable
     */
    protected $LoginIps;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.LoginIps',
        'app.Users',
        'app.LocationsUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LoginIps') ? [] : ['className' => LoginIpsTable::class];
        $this->LoginIps = $this->getTableLocator()->get('LoginIps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoginIps);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoginIpsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoginIpsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
