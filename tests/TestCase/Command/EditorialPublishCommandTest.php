<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use Cake\Command\Command;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\EditorialPublishCommand Test Case
 *
 * @uses \App\Command\EditorialPublishCommand
 */
class EditorialPublishCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Content',
        'app.Corps',
        'app.Wikis',
    ];

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContentTable
     * @var \App\Model\Table\CorpsTable
     * @var \App\Model\Table\WikisTable
     */
    protected $Content;
    protected $Corps;
    protected $Wikis;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();
        $this->Content = $this->getTableLocator()->get('Content');
        $this->Corps = $this->getTableLocator()->get('Corps');
        $this->Wikis = $this->getTableLocator()->get('Wikis');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Content);
        unset($this->Wikis);
        unset($this->Corps);
        parent::tearDown();
    }

    /**
     * Test buildOptionParser method - returns description
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::buildOptionParser()
     * @test
     * @testdox buildOptionParser method - returns description
     */
    public function descriptionOutput(): void
    {
        $this->exec('editorial publish --help');
        $this->assertExitSuccess();
        $this->assertOutputContains('The model to publish items from.');
    }

    /**
     * Test buildOptionParser method - returns options
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::buildOptionParser()
     * @test
     * @testdox buildOptionParser method - returns options
     */
    public function optionsOutput(): void
    {
        $this->exec('editorial publish --help');
        $this->assertExitSuccess();
        $this->assertOutputContains('<Content|Corps|Wikis>');
    }

    /**
     * Test buildOptionParser method - requires `model` argument
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::buildOptionParser()
     * @test
     * @testdox buildOptionParser method - requires `model` argument
     */
    public function missingArgumentError(): void
    {
        $this->exec('editorial publish');
        $this->assertExitError();
        $this->assertErrorContains('Error: Missing required argument. The `model` argument is required.');
    }

    /**
     * Test execute method can publish Content items
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::execute()
     * @test
     * @testdox execute - Can publish Content items
     */
    public function executeCanPublishContentItems(): void
    {
        $this->assertCount(1, $this->Content->find('publishableItems')->all());

        $this->exec('editorial publish Content');

        $this->assertExitCode(Command::CODE_SUCCESS);
        $this->assertCount(0, $this->Content->find('publishableItems')->all());
    }

    /**
     * Test execute method successful when there are 0 publishable Content items
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::execute()
     * @test
     * @testdox execute - Success when there are 0 publishable Content items
     */
    public function executeHandlesZeroPublishableContentItems(): void
    {
        $this->exec('editorial publish Content'); // Publishes 1 Content item
        $this->exec('editorial publish Content');

        $this->assertExitCode(Command::CODE_SUCCESS);
        $this->assertOutputContains('Publishing 0 items');
    }

    /**
     * Test execute method can publish Corps items
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::execute()
     * @test
     * @testdox execute - Can publish Corps items
     */
    public function executeCanPublishCorpsItems(): void
    {
        $this->assertCount(1, $this->Corps->find('publishableItems')->all());

        $this->exec('editorial publish Corps');

        $this->assertExitCode(Command::CODE_SUCCESS);
        $this->assertCount(0, $this->Corps->find('publishableItems')->all());
    }

    /**
     * Test execute method successful when there are 0 publishable Corps items
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::execute()
     * @test
     * @testdox execute - Success when there are 0 publishable Corps items
     */
    public function executeHandlesZeroPublishableCorpsItems(): void
    {
        $this->exec('editorial publish Corps'); // Publishes 1 Corps item
        $this->exec('editorial publish Corps');

        $this->assertExitCode(Command::CODE_SUCCESS);
        $this->assertOutputContains('Publishing 0 items');
    }

    /**
     * Test execute method can publish Wikis items
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::execute()
     * @test
     * @testdox execute - Can publish Wikis items
     */
    public function executeCanPublishWikisItems(): void
    {
        $this->assertCount(1, $this->Wikis->find('publishableItems')->all());

        $this->exec('editorial publish Wikis');

        $this->assertExitCode(Command::CODE_SUCCESS);
        $this->assertCount(0, $this->Wikis->find('publishableItems')->all());
    }

    /**
     * Test execute method successful when there are 0 publishable Wikis items
     *
     * @return void
     * @uses \App\Command\EditorialPublishCommand::execute()
     * @test
     * @testdox execute - Success when there are 0 publishable Wikis items
     */
    public function executeHandlesZeroPublishableWikisItems(): void
    {
        $this->exec('editorial publish Wikis'); // Publishes 1 Wikis item
        $this->exec('editorial publish Wikis');

        $this->assertExitCode(Command::CODE_SUCCESS);
        $this->assertOutputContains('Publishing 0 items');
    }
}
