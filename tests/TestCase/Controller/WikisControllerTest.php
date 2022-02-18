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
     * Test index method
     *
     * @return void
     * @uses \App\Controller\WikisController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\WikisController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
