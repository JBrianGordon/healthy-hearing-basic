<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\CallSourcesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\CallSourcesController Test Case
 *
 * @uses \App\Controller\Admin\CallSourcesController
 */
class CallSourcesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CallSources',
        'app.Locations',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\CallSourcesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
