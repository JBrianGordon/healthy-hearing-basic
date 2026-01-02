<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\LocationsFindListingTypesForOticonCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\LocationsFindListingTypesForOticonCommand Test Case
 *
 * @uses \App\Command\LocationsFindListingTypesForOticonCommand
 */
class LocationsFindListingTypesForOticonCommandTest extends TestCase
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
     * @uses \App\Command\LocationsFindListingTypesForOticonCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\LocationsFindListingTypesForOticonCommand::execute()
     */
    public function testExecute(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
