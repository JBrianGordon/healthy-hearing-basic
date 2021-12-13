<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationAdsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationAdsTable Test Case
 */
class LocationAdsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationAdsTable
     */
    protected $LocationAds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LocationAds',
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
        $config = $this->getTableLocator()->exists('LocationAds') ? [] : ['className' => LocationAdsTable::class];
        $this->LocationAds = $this->getTableLocator()->get('LocationAds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationAds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LocationAdsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LocationAdsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
