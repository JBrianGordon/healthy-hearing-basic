<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\ContentController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ContentController Test Case
 *
 * @uses \App\Controller\Admin\ContentController
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
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::delete()
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
     * Test draft method with unnallowed GET request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::draft()
     * @test
     * @testdox Test draft method with unallowed GET request
     */
    public function draftWithUnallowedGetRequest(): void
    {
        $this->get('/admin/content/draft/1');
        $this->assertResponseError();
    }

    /**
     * Test draft method with unnallowed PUT request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::draft()
     * @test
     * @testdox Test draft method with unallowed PUT request
     */
    public function draftWithUnallowedPutRequest(): void
    {
        $this->put('/admin/content/draft/1');
        $this->assertResponseError();
    }

    /**
     * Test draft method with unnallowed DELETE request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::draft()
     * @test
     * @testdox Test draft method with unallowed DELETE request
     */
    public function draftWithUnallowedDeleteRequest(): void
    {
        $this->delete('/admin/content/draft/1');
        $this->assertResponseError();
    }

    /**
     * Test draft method with unnallowed PATCH request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::draft()
     * @test
     * @testdox Test draft method with unallowed PATCH request
     */
    public function draftWithUnallowedPatchRequest(): void
    {
        $this->patch('/admin/content/draft/1');
        $this->assertResponseError();
    }

    /**
     * Test that draft method can create new Content draft
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::draft()
     * @test
     * @testdox Test that draft method can create new Content draft
     */
    public function draftToCreateNewContentDraft(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/content/draft/2');
        $this->assertRedirect('admin/content/edit/9');
    }

    /**
     * Test that draft method can redirect to existing Content draft
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::draft()
     * @test
     * @testdox Test that draft method can redirect to existing Content draft
     */
    public function draftToRedirectToExistingContentDraft(): void
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/content/draft/1');
        $this->assertRedirect('admin/content/edit/7');
        $this->assertFlashMessage('This report has an existing draft below.', 'flash');
    }
    // * * * * *

    // * * * * *
    //
    // publish() test methods
    //
    // * * * * *

    /**
     * Test publish method with unnallowed GET request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::publish()
     * @test
     * @testdox Test publish method with unallowed GET request
     */
    public function publishWithUnallowedGetRequest(): void
    {
        $this->get('/admin/content/publish/7');
        $this->assertResponseError();
    }

    /**
     * Test publish method with unnallowed PUT request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::publish()
     * @test
     * @testdox Test publish method with unallowed PUT request
     */
    public function publishWithUnallowedPutRequest(): void
    {
        $this->put('/admin/content/publish/7');
        $this->assertResponseError();
    }

    /**
     * Test publish method with unnallowed DELETE request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::publish()
     * @test
     * @testdox Test publish method with unallowed DELETE request
     */
    public function publishWithUnallowedDeleteRequest(): void
    {
        $this->delete('/admin/content/publish/7');
        $this->assertResponseError();
    }

    /**
     * Test publish method with unnallowed PATCH request
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::publish()
     * @test
     * @testdox Test publish method with unallowed PATCH request
     */
    public function publishWithUnallowedPatchRequest(): void
    {
        $this->patch('/admin/content/publish/7');
        $this->assertResponseError();
    }

    /**
     * Test that draft method can redirect to existing Content draft
     *
     * @return void
     * @uses \App\Controller\Admin\ContentController::publish()
     * @test
     * @testdox Test that publish method can publish a Content draft by updating and existing report
     */
    public function publishContentDraftByUpdatingExistingReport(): void
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/content/publish/7');
        $this->assertRedirect('admin/content/edit/1');
        $this->assertFlashMessage('Republish successful!', 'flash');
    }
    // * * * * *
}