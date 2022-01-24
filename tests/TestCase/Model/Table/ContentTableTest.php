<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContentTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContentTable Test Case
 */
class ContentTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContentTable
     */
    protected $Content;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Content',
        'app.Users',
        'app.Locations',
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
        $config = $this->getTableLocator()->exists('Content') ? [] : ['className' => ContentTable::class];
        $this->Content = $this->getTableLocator()->get('Content', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Content);

        parent::tearDown();
    }

    /**
     * Test validationDefault method with passing data
     * @return void
     * @test
     * @uses \App\Model\Table\ContentTable::validationDefault()
     * @testdox Test that Content validation rules are working with passing data
     */
    public function validationDefaultWithPassingData(): void
    {
        $data = [
            'type' => 'article',
            'title' => 'A great Healthy Hearing report',
            'body' => 'This is the report body',
            'facebook_image_alt' => 'Facebook image alt text',
        ];

        $report = $this->Content->newEntity($data);
        $this->assertEmpty($report->getErrors());
    }

    /**
     * Test validationDefault method with missing data
     * @return void
     * @test
     * @uses \App\Model\Table\ContentTable::validationDefault()
     * @testdox Test that Content validation rules are working with missing data
     */
    public function validationDefaultWithMissingData(): void
    {
        $data = [];
        $report = $this->Content->newEntity($data);
        $this->assertCount(4, $report->getErrors());
    }

    /**
     * Test validationDefault method with empty string data
     * @return void
     * @test
     * @uses \App\Model\Table\ContentTable::validationDefault()
     * @testdox Test that Content validation rules are working with empty string data
     */
    public function validationDefaultWithEmptyStringData(): void
    {
        $data = [
            'type' => '',
            'title' => '',
            'body' => '',
            'facebook_image_alt' => '',
        ];
        $report = $this->Content->newEntity($data);
        $this->assertCount(4, $report->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ContentTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * @dataProvider findLatestProvider
     * @return void
     * @test
     * @testdox Requesting the latest n articles/reports/Content items returns n items
     */
    public function findLatest(array $input, array $expected): void
    {
        $latestArticleIds = $this->Content->find('latest', $input)
            ->disableHydration()
            ->all()
            ->extract('id')
            ->toArray();
        $this->assertEquals($expected, $latestArticleIds);
    }

    public function findLatestProvider(): array
    {
        return [
            [
                ['numArticles' => 4], [6, 5, 4, 3]
            ],
            [
                ['numArticles' => 2], [6, 5]
            ],
            [
                ['numArticles' => 0], []
            ],
            [
                ['numArticles' => 10], [6, 5, 4, 3, 2, 1] // only 6 content/article fixtures
            ]
        ];
    }

    /**
     * @return void
     * @test
     * @testdox Requesting the latest articles/reports/Content items returns the default value of 4 items
     */
    public function findLatestDefault(): void
    {
        $latestArticleIds = $this->Content->find('latest')
            ->disableHydration()
            ->all()
            ->extract('id')
            ->toArray();
        $expected = [6, 5, 4, 3];
        $this->assertEquals($expected, $latestArticleIds);
    }


}