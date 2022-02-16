<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WikisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WikisTable Test Case
 */
class WikisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WikisTable
     */
    protected $Wikis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Wikis',
        'app.Users',
        'app.TagWikis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Wikis') ? [] : ['className' => WikisTable::class];
        $this->Wikis = $this->getTableLocator()->get('Wikis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Wikis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method with passing data
     * @return void
     * @test
     * @uses \App\Model\Table\WikisTable::validationDefault()
     * @testdox Test that Wikis validation rules are working with passing data
     */
    public function validationDefaultWithPassingData(): void
    {
        $data = [
            'name' => 'Name of the wiki',
            'slug' => '/help/wiki-slug',
            'body' => 'This is the wiki body',
            'is_active' => '1',
            'priority' => '10',
            'title_head' => 'Title head of the wiki',
            'title_h1' => 'Title H1 of the wiki',
            'facebook_image_alt' => 'Facebook image alt text',
            'last_modified' => '2022-04-03 21:24:20',
        ];

        $report = $this->Wikis->newEntity($data);
        $this->assertEmpty($report->getErrors());
    }

    /**
     * Test validationDefault method with missing data
     * @return void
     * @test
     * @uses \App\Model\Table\WikisTable::validationDefault()
     * @testdox Test that Wiki validation rules are working with missing data
     */
    public function validationDefaultWithMissingData(): void
    {
        $data = [];
        $wiki = $this->Wikis->newEntity($data);
        $this->assertCount(7, $wiki->getErrors());
    }

    /**
     * Test validationDefault method with empty string data
     * @return void
     * @test
     * @uses \App\Model\Table\WikisTable::validationDefault()
     * @testdox Test that Wikis validation rules are working with empty string data
     */
    public function validationDefaultWithEmptyStringData(): void
    {
        $data = [
            'name' => '',
            'slug' => '',
            'body' => '',
            'is_active' => '',
            'priority' => '',
            'title_head' => '',
            'title_h1' => '',
            'facebook_image_alt' => '',
            'last_modified' => '',
        ];
        $report = $this->Wikis->newEntity($data);
        $this->assertCount(9, $report->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WikisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
