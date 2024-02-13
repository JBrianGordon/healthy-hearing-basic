<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\PersistQueriesComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\PersistQueriesComponent Test Case
 */
class PersistQueriesComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\PersistQueriesComponent
     */
    protected $PersistQueries;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->PersistQueries = new PersistQueriesComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PersistQueries);

        parent::tearDown();
    }
}
