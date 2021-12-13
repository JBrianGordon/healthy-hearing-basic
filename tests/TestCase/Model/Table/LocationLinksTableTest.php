<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationLinksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationLinksTable Test Case
 */
class LocationLinksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationLinksTable
     */
    protected $LocationLinks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationLinks',
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
        $config = $this->getTableLocator()->exists('LocationLinks') ? [] : ['className' => LocationLinksTable::class];
        $this->LocationLinks = $this->getTableLocator()->get('LocationLinks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationLinks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationLinksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationLinksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
