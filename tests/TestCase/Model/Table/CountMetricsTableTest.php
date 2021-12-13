<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountMetricsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountMetricsTable Test Case
 */
class CountMetricsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CountMetricsTable
     */
    protected $CountMetrics;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CountMetrics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CountMetrics') ? [] : ['className' => CountMetricsTable::class];
        $this->CountMetrics = $this->getTableLocator()->get('CountMetrics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CountMetrics);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CountMetricsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
