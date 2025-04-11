<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\EditorialFreezeContentCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\EditorialFreezeContentCommand Test Case
 *
 * @uses \App\Command\EditorialFreezeContentCommand
 */
class EditorialFreezeContentCommandTest extends TestCase
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
     * @uses \App\Command\EditorialFreezeContentCommand::buildOptionParser()
     */
    public function testBuildOptionParser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     * @uses \App\Command\EditorialFreezeContentCommand::execute()
     */
    public function testExecute(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
