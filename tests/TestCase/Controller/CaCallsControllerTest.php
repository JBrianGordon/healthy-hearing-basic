<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CaCallsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CaCallsController Test Case
 *
 * @uses \App\Controller\CaCallsController
 */
class CaCallsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CaCalls',
        'app.CaCallGroups',
        'app.Users',
    ];
}
