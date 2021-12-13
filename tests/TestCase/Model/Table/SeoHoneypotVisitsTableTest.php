<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeoHoneypotVisitsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeoHoneypotVisitsTable Test Case
 */
class SeoHoneypotVisitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeoHoneypotVisitsTable
     */
    protected $SeoHoneypotVisits;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SeoHoneypotVisits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoHoneypotVisits') ? [] : ['className' => SeoHoneypotVisitsTable::class];
        $this->SeoHoneypotVisits = $this->getTableLocator()->get('SeoHoneypotVisits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SeoHoneypotVisits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SeoHoneypotVisitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
