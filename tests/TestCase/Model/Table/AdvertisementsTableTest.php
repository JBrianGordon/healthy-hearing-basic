<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdvertisementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdvertisementsTable Test Case
 */
class AdvertisementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdvertisementsTable
     */
    protected $Advertisements;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Advertisements',
        'app.Corps',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Advertisements') ? [] : ['className' => AdvertisementsTable::class];
        $this->Advertisements = $this->getTableLocator()->get('Advertisements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Advertisements);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AdvertisementsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AdvertisementsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
