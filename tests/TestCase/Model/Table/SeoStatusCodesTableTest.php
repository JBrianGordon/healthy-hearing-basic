<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoStatusCodesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoStatusCodesTable Test Case
 */
class SeoStatusCodesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoStatusCodesTable
     */
    protected $SeoStatusCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoStatusCodes',
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
        $config = $this->getTableLocator()->exists('SeoStatusCodes') ? [] : ['className' => SeoStatusCodesTable::class];
        $this->SeoStatusCodes = $this->getTableLocator()->get('SeoStatusCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoStatusCodes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoStatusCodesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SeoStatusCodesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
