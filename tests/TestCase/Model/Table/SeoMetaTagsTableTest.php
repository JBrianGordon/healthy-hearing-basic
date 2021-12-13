<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoMetaTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoMetaTagsTable Test Case
 */
class SeoMetaTagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoMetaTagsTable
     */
    protected $SeoMetaTags;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoMetaTags',
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
        $config = $this->getTableLocator()->exists('SeoMetaTags') ? [] : ['className' => SeoMetaTagsTable::class];
        $this->SeoMetaTags = $this->getTableLocator()->get('SeoMetaTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoMetaTags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoMetaTagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SeoMetaTagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
