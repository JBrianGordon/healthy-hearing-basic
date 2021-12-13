<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoBlacklistsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoBlacklistsTable Test Case
 */
class SeoBlacklistsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoBlacklistsTable
     */
    protected $SeoBlacklists;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoBlacklists',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoBlacklists') ? [] : ['className' => SeoBlacklistsTable::class];
        $this->SeoBlacklists = $this->getTableLocator()->get('SeoBlacklists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoBlacklists);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoBlacklistsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
