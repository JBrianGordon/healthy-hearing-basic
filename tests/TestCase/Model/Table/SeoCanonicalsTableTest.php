<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoCanonicalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoCanonicalsTable Test Case
 */
class SeoCanonicalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoCanonicalsTable
     */
    protected $SeoCanonicals;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoCanonicals',
        'app.SeoUris',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoCanonicals') ? [] : ['className' => SeoCanonicalsTable::class];
        $this->SeoCanonicals = $this->getTableLocator()->get('SeoCanonicals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoCanonicals);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoCanonicalsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SeoCanonicalsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
