<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationVideosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationVideosTable Test Case
 */
class LocationVideosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationVideosTable
     */
    protected $LocationVideos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationVideos',
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
        $config = $this->getTableLocator()->exists('LocationVideos') ? [] : ['className' => LocationVideosTable::class];
        $this->LocationVideos = $this->getTableLocator()->get('LocationVideos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationVideos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationVideosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationVideosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
