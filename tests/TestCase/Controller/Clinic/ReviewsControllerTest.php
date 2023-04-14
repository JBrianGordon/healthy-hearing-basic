<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Clinic;

use App\Controller\Clinic\ReviewsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Clinic\ReviewsController Test Case
 *
 * @uses \App\Controller\Clinic\ReviewsController
 */
class ReviewsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Reviews',
        'app.Locations',
        'app.Zips',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Clinic\ReviewsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test respond method
     *
     * @return void
     * @uses \App\Controller\Clinic\ReviewsController::respond()
     */
    public function testRespond(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
