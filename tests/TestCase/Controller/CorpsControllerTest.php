<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CorpsController Test Case
 *
 * @uses \App\Controller\CorpsController
 */
class CorpsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var \App\Model\Table\CorpsTable
     */
    protected $Corps;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Corps',
        'app.Users',
        'app.Advertisements',
        'app.CorpsUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Corps = $this->getTableLocator()->get('Corps');

        // Add CorpsFixture slugs to 'corpsRegex' config used in routing
        $corpSlugsFromConfig = Configure::read('corps');
        $testCorpSlugs = $this->Corps->find()->all()->extract('slug')->toArray();
        $allCorpSlugs = array_merge($corpSlugsFromConfig, $testCorpSlugs);

        Configure::write('corpsRegex', '(?i:' . implode('|', $allCorpSlugs) . ')');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Corps);

        parent::tearDown();
    }

    /**
     * Test index method - /hearing-aid-manufacturers returns correct number of is_active Corps
     *
     * @return void
     * @uses \App\Controller\CorpsController::index()
     * @test
     * @testdox Index - /hearing-aid-manufacturers returns correct number of is_active Corps
     */
    public function index(): void
    {
        $this->get('/hearing-aid-manufacturers');
        $corps = $this->viewVariable('corps');
        $this->assertCount(3, $corps);
    }

    /**
     * View - returns 2xx/OK response code at working URL
     *
     * @return void
     * @uses \App\Controller\CorpsController::view()
     * @test
     * @testdox View - returns 2xx/OK response code at working Corp URL
     */
    public function viewReturns2xxAtGoodUrl(): void
    {
        $corp = $this->Corps->get(1);
        $this->get($corp->slug);
        $this->assertResponseOk();
        $this->assertResponseContains($corp->title);
    }

    /**
     * View - returns redirect for working URL with trailing slash to non-slash URL
     *
     * @return void
     * @uses \App\Controller\CorpsController::view()
     * @test
     * @testdox View - returns redirect for working URL with trailing slash to non-slash URL
     */
    public function viewReturns2xxAtGoodUrlWithTrailingSlash(): void
    {
        $corp = $this->Corps->get(1);
        $this->get($corp->slug . '/');
        $this->assertRedirect($corp->slug);
    }

    /**
     * View - 2xx/OK response contains corp title
     *
     * @return void
     * @uses \App\Controller\CorpsController::view()
     * @test
     * @testdox View - 2xx/OK response contains corp title
     */
    public function viewWorkingUrlResponseContainsTitle(): void
    {
        $corp = $this->Corps->get(1);
        $this->get($corp->slug);
        $this->assertResponseContains($corp->title);
    }

    /**
     * View - returns 4xx for non-existent Corp URL
     *
     * @return void
     * @uses \App\Controller\CorpsController::view()
     * @test
     * @testdox View - returns 4xx for non-existent Corp URL
     */
    public function viewReturns4xxAtNonexistentUrl(): void
    {
        $this->get('/not-real-corp-URL');
        $this->assertResponseError();
    }
}
