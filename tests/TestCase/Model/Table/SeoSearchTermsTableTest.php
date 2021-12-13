<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoSearchTermsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoSearchTermsTable Test Case
 */
class SeoSearchTermsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoSearchTermsTable
     */
    protected $SeoSearchTerms;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoSearchTerms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoSearchTerms') ? [] : ['className' => SeoSearchTermsTable::class];
        $this->SeoSearchTerms = $this->getTableLocator()->get('SeoSearchTerms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoSearchTerms);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoSearchTermsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
