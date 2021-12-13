<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportsTable Test Case
 */
class ImportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportsTable
     */
    protected $Imports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Imports',
        'app.ImportDiffs',
        'app.ImportLocationProviders',
        'app.ImportLocations',
        'app.ImportProviders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Imports') ? [] : ['className' => ImportsTable::class];
        $this->Imports = $this->getTableLocator()->get('Imports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Imports);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ImportsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
