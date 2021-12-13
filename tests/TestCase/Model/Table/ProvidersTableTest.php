<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProvidersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProvidersTable Test Case
 */
class ProvidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProvidersTable
     */
    protected $Providers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Providers',
        'app.ImportProviders',
        'app.LocationProviders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Providers') ? [] : ['className' => ProvidersTable::class];
        $this->Providers = $this->getTableLocator()->get('Providers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Providers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProvidersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
