<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * EditorialPublish command.
 */
class EditorialPublishCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'editorial publish';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);
        $parser
            ->setDescription('Publish items for a given model')
            ->addArgument('model', [
                'help' => 'The model to publish items from. For example, ' .
                    '`cake editorial publish content` will publish ready-to-publish ' .
                    'items of the type \'content\'.',
                'required' => true,
                'choices' => ['Content', 'Corps', 'Wikis'],
            ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $model = $args->getArgument('model');
        $table = $this->fetchTable($model);

        $io->out("Publishing {$model}...");
        $io->out('Searching for drafts which have a last mod date of today or before');

        $itemsToPublish = $table->find('publishableItems')->all();

        $io->out('Publishing ' . count($itemsToPublish) . ' items');

        foreach ($itemsToPublish as $itemToPublish) {
            $table->publish($itemToPublish->id);
        }
    }
}
