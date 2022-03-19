<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ContentController Test Case
 *
 * @uses \App\Controller\ContentController
 */
class ContentControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.ContentUsers',
        'app.ContentLocations',
        'app.ContentTags',
    ];

    /**
     * Test reportIndex method - returns 2xx/OK response, contains 'Reports', and uses correct 'report_index' template
     *
     * @return void
     * @uses \App\Controller\ContentController::reportIndex()
     * @test
     * @testdox /report returns 2xx/OK response code, response contains 'Reports', and 'report_index' template is rendered
     */
    public function reportIndexIsOk(): void
    {
        $this->get('/report');
        $this->assertResponseOk();
        $this->assertResponseContains('Reports');
        $this->assertTemplate('report_index');
    }

    /**
     * Test reportIndex method - /report returns correct number of is_active Content items
     *
     * @return void
     * @uses \App\Controller\ContentController::reportIndex()
     * @test
     * @testdox /report returns correct number of is_active Content items
     */
    public function index(): void
    {
        $this->get('/report');
        $reports = $this->viewVariable('reports');
        $this->assertCount(6, $reports);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\ContentController::view()
     * @test
     * @testdox /report/reportId-reportSlug returns 2xx/OK response code, response contains report title, and 'view' template is rendered
     */
    public function viewIsOk(): void
    {
        $this->Content = $this->getTableLocator()->get('Content');
        $report = $this->Content->get(1, [
            'contain' => ['PrimaryAuthor']
        ]);
        $reportUrl = $report->hh_url;
        $this->get($reportUrl);
        $this->assertResponseOk();
        $this->assertResponseContains($report->title);
        $this->assertResponseContains($report->primary_author->full_name);
        $this->assertTemplate('view');
    }
}
