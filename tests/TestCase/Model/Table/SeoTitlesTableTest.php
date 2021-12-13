<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoTitlesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoTitlesTable Test Case
 */
class SeoTitlesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoTitlesTable
     */
    protected $SeoTitles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoTitles',
        'app.SeoUris',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoTitles') ? [] : ['className' => SeoTitlesTable::class];
        $this->SeoTitles = $this->getTableLocator()->get('SeoTitles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoTitles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoTitlesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SeoTitlesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
