<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CorpsController;
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
     * @uses \App\Controller\CorpsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\CorpsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
