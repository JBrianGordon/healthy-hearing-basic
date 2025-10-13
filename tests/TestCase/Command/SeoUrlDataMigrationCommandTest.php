<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\SeoUrlDataMigrationCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\SeoUrlDataMigrationCommand Test Case
 *
 * @uses \App\Command\SeoUrlDataMigrationCommand
 */
class SeoUrlDataMigrationCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();
    }
    /**
     * Test buildOptionParser method
     *
     * @return void
     * @uses \App\Command\SeoUrlDataMigrationCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\SeoUrlDataMigrationCommand::execute()
     */
    public function testExecute(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
