<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoUrisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoUrisTable Test Case
 */
class SeoUrisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoUrisTable
     */
    protected $SeoUris;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoUris',
        'app.SeoCanonicals',
        'app.SeoMetaTags',
        'app.SeoRedirects',
        'app.SeoStatusCodes',
        'app.SeoTitles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoUris') ? [] : ['className' => SeoUrisTable::class];
        $this->SeoUris = $this->getTableLocator()->get('SeoUris', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoUris);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoUrisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SeoUrisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
