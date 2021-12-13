<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationVidscripsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationVidscripsTable Test Case
 */
class LocationVidscripsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationVidscripsTable
     */
    protected $LocationVidscrips;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationVidscrips',
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
        $config = $this->getTableLocator()->exists('LocationVidscrips') ? [] : ['className' => LocationVidscripsTable::class];
        $this->LocationVidscrips = $this->getTableLocator()->get('LocationVidscrips', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationVidscrips);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationVidscripsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationVidscripsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
