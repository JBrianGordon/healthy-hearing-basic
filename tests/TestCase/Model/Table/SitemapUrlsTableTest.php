<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SitemapUrlsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SitemapUrlsTable Test Case
 */
class SitemapUrlsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SitemapUrlsTable
     */
    protected $SitemapUrls;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SitemapUrls',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SitemapUrls') ? [] : ['className' => SitemapUrlsTable::class];
        $this->SitemapUrls = $this->getTableLocator()->get('SitemapUrls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SitemapUrls);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SitemapUrlsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SitemapUrlsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
