<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ReviewsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ReviewsController Test Case
 *
 * @uses \App\Controller\ReviewsController
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
    ];

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ReviewsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
