<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ZipcodesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ZipcodesTable Test Case
 */
class ZipcodesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ZipcodesTable
     */
    protected $Zipcodes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Zipcodes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Zipcodes') ? [] : ['className' => ZipcodesTable::class];
        $this->Zipcodes = $this->getTableLocator()->get('Zipcodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Zipcodes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ZipcodesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ZipcodesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
