<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * EditorialFreezeContent command.
 */
class EditorialFreezeContentCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'editorial freezeContent';
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

        $parser->setDescription('Freeze all content items with a publication date earlier than today');
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
        $table = $this->fetchTable('Content');

        $io->out('Updating all content items where the publication date is earlier than today to be _frozen_');

        $count = $table->updateAll(
            [
                'is_frozen' => 1,
            ],
            [
                'date < CURDATE()',
                'is_active' => 1,
                'id_draft_parent' => 0 //don't freeze drafts
            ]
        );

        $io->out($count . ' rows affected.');
    }
}
