<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\CorpsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\CorpsController Test Case
 *
 * @uses \App\Controller\Admin\CorpsController
 */
class CorpsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::delete()
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
     * @uses \App\Controller\Admin\CorpsController::draft()
     * @test
     * @testdox Draft method with unallowed GET request FAILS
     */
    public function draftWithUnallowedGetRequest(): void
    {
        $this->get('/admin/corps/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method with unnallowed PUT request
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::draft()
     * @test
     * @testdox Draft method with unallowed PUT request FAILS
     */
    public function draftWithUnallowedPutRequest(): void
    {
        $this->put('/admin/corps/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method with unnallowed DELETE request
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::draft()
     * @test
     * @testdox Draft method with unallowed DELETE request FAILS
     */
    public function draftWithUnallowedDeleteRequest(): void
    {
        $this->delete('/admin/corps/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method with unnallowed PATCH request
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::draft()
     * @test
     * @testdox Draft method with unallowed PATCH request FAILS
     */
    public function draftWithUnallowedPatchRequest(): void
    {
        $this->patch('/admin/corps/draft/1');
        $this->assertResponseError();
    }

    /**
     * Draft method can create new Corp draft
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::draft()
     * @test
     * @testdox Draft method can create new Corp draft
     */
    public function draftToCreateNewCorpDraft(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/corps/draft/3');
        $this->assertRedirect('admin/corps/edit/6');
    }

    /**
     * Draft method can redirect to existing Corp draft
     *
     * @return void
     * @uses \App\Controller\Admin\CorpsController::draft()
     * @test
     * @testdox Draft method can redirect to existing Corp draft
     */
    public function draftToRedirectToExistingCorpDraft(): void
    {
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/corps/draft/1');
        $this->assertRedirect('admin/corps/edit/4');
        $this->assertFlashMessage('This report has an existing draft below.', 'flash');
    }
    // * * * * *
}
