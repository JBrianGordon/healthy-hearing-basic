<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Clinic;

use App\Controller\Clinic\PagesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Clinic\PagesController Test Case
 *
 * @uses \App\Controller\Clinic\PagesController
 */
class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Pages',
        'app.Users',
    ];

    /**
     * Test clinicFaq method
     *
     * @return void
     * @uses \App\Controller\Clinic\PagesController::clinicFaq()
     */
    public function testClinicFaq(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
