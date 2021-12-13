<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoRedirectsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoRedirectsTable Test Case
 */
class SeoRedirectsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoRedirectsTable
     */
    protected $SeoRedirects;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoRedirects',
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
        $config = $this->getTableLocator()->exists('SeoRedirects') ? [] : ['className' => SeoRedirectsTable::class];
        $this->SeoRedirects = $this->getTableLocator()->get('SeoRedirects', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoRedirects);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoRedirectsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SeoRedirectsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
