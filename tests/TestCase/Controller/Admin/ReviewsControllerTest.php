<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ReviewsController Test Case
 *
 * @uses \App\Controller\Admin\ReviewsController
 */
class ReviewsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Reviews',
        'app.Locations',
        'app.Users',
    ];

    /**
     * Test subject
     *
     * @var \App\Model\Table\ReviewsTable
     */
    protected $Reviews;

    /**
     * login method to set session Auth
     *
     * @return void
     */
    protected function login($userId = 1): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get($userId);
        $this->session(['Auth' => $user]);
    }

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->Reviews = $this->getTableLocator()->get('Reviews');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->cleanup();
        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\ReviewsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\ReviewsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\ReviewsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Delete method redirects to admin/reviews after successful delete
     *
     * @return void
     * @uses \App\Controller\Admin\ReviewsController::delete()
     * @test
     * @testdox Delete method redirects to admin/reviews after successful delete
     */
    public function successfulDeleteRedirectsToIndex(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/reviews/delete/1');
        $this->assertRedirect('admin/reviews');
    }

    /**
     * Delete method reduces review count by 1 after successful delete
     *
     * @return void
     * @uses \App\Controller\Admin\ReviewsController::delete()
     * @test
     * @testdox Delete method reduces review count by 1 after successful delete
     */
    public function successfulDeleteReducesReviewCountByOne(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $originalReviewCount = $this->Reviews->find()->count();
        $this->post('/admin/reviews/delete/1');
        $this->assertEquals($originalReviewCount - 1, $this->Reviews->find()->count());
    }

    /**
     * Test ignore method
     *
     * @return void
     * @uses \App\Controller\Admin\ReviewsController::ignore()
     */
    public function testIgnore(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
