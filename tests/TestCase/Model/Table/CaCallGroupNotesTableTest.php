<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CaCallGroupNotesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CaCallGroupNotesTable Test Case
 */
class CaCallGroupNotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CaCallGroupNotesTable
     */
    protected $CaCallGroupNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CaCallGroupNotes',
        'app.CaCallGroups',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CaCallGroupNotes') ? [] : ['className' => CaCallGroupNotesTable::class];
        $this->CaCallGroupNotes = $this->getTableLocator()->get('CaCallGroupNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CaCallGroupNotes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CaCallGroupNotesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CaCallGroupNotesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
