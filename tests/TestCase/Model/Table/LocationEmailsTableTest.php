<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationEmailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationEmailsTable Test Case
 */
class LocationEmailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationEmailsTable
     */
    protected $LocationEmails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationEmails',
        'app.Locations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LocationEmails') ? [] : ['className' => LocationEmailsTable::class];
        $this->LocationEmails = $this->getTableLocator()->get('LocationEmails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationEmails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationEmailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationEmailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
