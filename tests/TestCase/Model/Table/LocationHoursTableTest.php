<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationHoursTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationHoursTable Test Case
 */
class LocationHoursTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationHoursTable
     */
    protected $LocationHours;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationHours',
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
        $config = $this->getTableLocator()->exists('LocationHours') ? [] : ['className' => LocationHoursTable::class];
        $this->LocationHours = $this->getTableLocator()->get('LocationHours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationHours);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationHoursTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationHoursTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
