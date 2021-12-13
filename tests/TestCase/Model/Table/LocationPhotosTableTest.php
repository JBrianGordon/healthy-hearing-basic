<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationPhotosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationPhotosTable Test Case
 */
class LocationPhotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationPhotosTable
     */
    protected $LocationPhotos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationPhotos',
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
        $config = $this->getTableLocator()->exists('LocationPhotos') ? [] : ['className' => LocationPhotosTable::class];
        $this->LocationPhotos = $this->getTableLocator()->get('LocationPhotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationPhotos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationPhotosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationPhotosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
