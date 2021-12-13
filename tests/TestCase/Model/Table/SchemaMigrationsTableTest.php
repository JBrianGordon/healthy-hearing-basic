<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SchemaMigrationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SchemaMigrationsTable Test Case
 */
class SchemaMigrationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SchemaMigrationsTable
     */
    protected $SchemaMigrations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SchemaMigrations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SchemaMigrations') ? [] : ['className' => SchemaMigrationsTable::class];
        $this->SchemaMigrations = $this->getTableLocator()->get('SchemaMigrations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SchemaMigrations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SchemaMigrationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
