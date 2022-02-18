<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\WikisController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\WikisController Test Case
 *
 * @uses \App\Controller\Admin\WikisController
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
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    // * * * * *
    //
    // draft() test methods
    //
    // * * * * *

    /**
     * Draft method with unnallowed GET request
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::draft()
     * @test
     * @testdox Draft method with unallowed GET request FAILS
     */
    public function draftWithUnallowedGetRequest(): void
    {
        $this->get('/admin/wikis/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method with unnallowed PUT request
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::draft()
     * @test
     * @testdox Draft method with unallowed PUT request FAILS
     */
    public function draftWithUnallowedPutRequest(): void
    {
        $this->put('/admin/wikis/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method with unnallowed DELETE request
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::draft()
     * @test
     * @testdox Draft method with unallowed DELETE request FAILS
     */
    public function draftWithUnallowedDeleteRequest(): void
    {
        $this->delete('/admin/wikis/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method with unnallowed PATCH request
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::draft()
     * @test
     * @testdox Draft method with unallowed PATCH request FAILS
     */
    public function draftWithUnallowedPatchRequest(): void
    {
        $this->patch('/admin/wikis/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method can create new Wiki draft
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::draft()
     * @test
     * @testdox Draft method can create new Wiki draft
     */
    public function draftToCreateNewWikiDraft(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/wikis/draft/3');
        $this->assertRedirect('admin/wikis/edit/6');
    }

    /**
     * Draft method can redirect to existing Wiki draft
     *
     * @return void
     * @uses \App\Controller\Admin\WikisController::draft()
     * @test
     * @testdox Draft method can redirect to existing Wiki draft
     */
    public function draftToRedirectToExistingWikiDraft(): void
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/wikis/draft/1');
        $this->assertRedirect('admin/wikis/edit/4');
        $this->assertFlashMessage('This report has an existing draft below.', 'flash');
    }
    // * * * * *
}
