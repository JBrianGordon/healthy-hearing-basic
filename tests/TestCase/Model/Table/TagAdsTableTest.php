<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TagAdsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TagAdsTable Test Case
 */
class TagAdsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TagAdsTable
     */
    protected $TagAds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TagAds',
        'app.Ads',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TagAds') ? [] : ['className' => TagAdsTable::class];
        $this->TagAds = $this->getTableLocator()->get('TagAds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TagAds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TagAdsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TagAdsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
