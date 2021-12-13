<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuizResultsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuizResultsTable Test Case
 */
class QuizResultsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QuizResultsTable
     */
    protected $QuizResults;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.QuizResults',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('QuizResults') ? [] : ['className' => QuizResultsTable::class];
        $this->QuizResults = $this->getTableLocator()->get('QuizResults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->QuizResults);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\QuizResultsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
