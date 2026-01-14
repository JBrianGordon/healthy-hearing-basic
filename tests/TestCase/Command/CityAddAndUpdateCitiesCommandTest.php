<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\CityAddAndUpdateCitiesCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\CityAddAndUpdateCitiesCommand Test Case
 *
 * @uses \App\Command\CityAddAndUpdateCitiesCommand
 */
class CityAddAndUpdateCitiesCommandTest extends TestCase
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
     * @uses \App\Command\CityAddAndUpdateCitiesCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\CityAddAndUpdateCitiesCommand::execute()
     */
    public function testExecute(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
