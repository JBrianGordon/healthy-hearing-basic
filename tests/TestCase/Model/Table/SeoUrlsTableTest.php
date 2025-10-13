<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoUrlsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoUrlsTable Test Case
 */
class SeoUrlsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoUrlsTable
     */
    protected $SeoUrls;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SeoUrls',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoUrls') ? [] : ['className' => SeoUrlsTable::class];
        $this->SeoUrls = $this->getTableLocator()->get('SeoUrls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SeoUrls);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoUrlsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
