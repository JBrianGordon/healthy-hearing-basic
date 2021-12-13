<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContentTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContentTagsTable Test Case
 */
class ContentTagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContentTagsTable
     */
    protected $ContentTags;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ContentTags',
        'app.Contents',
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
        $config = $this->getTableLocator()->exists('ContentTags') ? [] : ['className' => ContentTagsTable::class];
        $this->ContentTags = $this->getTableLocator()->get('ContentTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ContentTags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ContentTagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ContentTagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
