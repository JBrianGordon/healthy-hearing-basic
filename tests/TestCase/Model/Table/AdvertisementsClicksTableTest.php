<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdvertisementsClicksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdvertisementsClicksTable Test Case
 */
class AdvertisementsClicksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdvertisementsClicksTable
     */
    protected $AdvertisementsClicks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AdvertisementsClicks',
        'app.Ads',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AdvertisementsClicks') ? [] : ['className' => AdvertisementsClicksTable::class];
        $this->AdvertisementsClicks = $this->getTableLocator()->get('AdvertisementsClicks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AdvertisementsClicks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AdvertisementsClicksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AdvertisementsClicksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
