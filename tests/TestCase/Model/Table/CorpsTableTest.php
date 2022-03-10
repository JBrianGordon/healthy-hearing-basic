<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorpsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorpsTable Test Case
 */
class CorpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CorpsTable
     */
    protected $Corps;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Corps',
        'app.Users',
        'app.Advertisements',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Corps') ? [] : ['className' => CorpsTable::class];
        $this->Corps = $this->getTableLocator()->get('Corps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Corps);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CorpsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CorpsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method with passing data
     *
     * @return void
     * @test
     * @uses \App\Model\Table\CorpsTable::validationDefault()
     * @testdox Test that Corps validation rules are working with passing data
     */
    public function validationDefaultWithPassingData(): void
    {
        $data = [
            'title' => 'Corp name',
            'priority' => '10',
        ];

        $report = $this->Corps->newEntity($data);
        $this->assertEmpty($report->getErrors());
    }

    /**
     * Test validationDefault method with missing data
     * @return void
     * @test
     * @uses \App\Model\Table\CorpsTable::validationDefault()
     * @testdox Test that Corps validation rules are working with missing data
     */
    public function validationDefaultWithMissingData(): void
    {
        $data = [];
        $report = $this->Corps->newEntity($data);
        $this->assertCount(2, $report->getErrors());
    }

    /**
     * Test validationDefault method with empty string data
     *
     * @return void
     * @test
     * @uses \App\Model\Table\CorpsTable::validationDefault()
     * @testdox Test that Corps validation rules are working with empty string data
     */
    public function validationDefaultWithEmptyStringData(): void
    {
        $data = [
            'title' => '',
            'priority' => '',
        ];
        $report = $this->Corps->newEntity($data);
        $this->assertCount(2, $report->getErrors());
    }
}
