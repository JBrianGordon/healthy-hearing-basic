<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\WikisController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\WikisController Test Case
 *
 * @uses \App\Controller\WikisController
 */
class WikisControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Wikis',
        'app.Users',
        'app.TagWikis',
        'app.UsersWikis',
    ];

    /**
     * Test index method - /help returns correct number of is_active Wikis
     *
     * @return void
     * @uses \App\Controller\WikisController::index()
     * @test
     * @testdox Index - /help returns correct number of is_active Wikis
     */
    public function index(): void
    {
        $this->get('/help');
        $wikis = $this->viewVariable('wikis');
        $this->assertCount(3, $wikis);
    }

    /**
     * View - returns 2xx/OK response code at working URL
     *
     * @return void
     * @uses \App\Controller\WikisController::view()
     * @test
     * @testdox View - returns 2xx/OK response code at working Wiki URL
     */
    public function viewReturns2xxAtGoodURL(): void
    {
        $this->Wikis = $this->getTableLocator()->get('Wikis');
        $wiki = $this->Wikis->get(1);
        $this->get('/help/'.$wiki->slug);
        $this->assertResponseOk();
    }

    /**
     * View - returns redirect for working URL with trailing slash to non-slash URL
     *
     * @return void
     * @uses \App\Controller\WikisController::view()
     * @test
     * @testdox View - returns redirect for working URL with trailing slash to non-slash URL
     */
    public function viewReturns2xxAtGoodUrlWithTrailingSlash(): void
    {
        $this->Wikis = $this->getTableLocator()->get('Wikis');
        $wiki = $this->Wikis->get(1);
        $this->get('/help/'.$wiki->slug.'/');
        $this->assertRedirect('/help/'.$wiki->slug);
    }

    /**
     * View - 2xx/OK response contains wiki title_h1
     *
     * @return void
     * @uses \App\Controller\WikisController::view()
     * @test
     * @testdox View - 2xx/OK response contains wiki title_h1
     */
    public function viewWorkingUrlResponseContainsTitleH1(): void
    {
        $this->Wikis = $this->getTableLocator()->get('Wikis');
        $wiki = $this->Wikis->get(1);
        $this->get('/help/'.$wiki->slug);
        $this->assertResponseContains($wiki->title_h1);
    }

    /**
     * View - returns redirect to '/help' for non-existent Wiki URL
     *
     * @return void
     * @uses \App\Controller\WikisController::view()
     * @test
     * @testdox View - returns redirect to '/help' for non-existent Wiki URL
     */
    public function viewReturns4xxAtNonexistentUrl(): void
    {
        $this->get('/help/hearing-aids/not-real-URL');
        $this->assertRedirect(['controller' => 'Wikis', 'action' => 'index']);
    }
}
