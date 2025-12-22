<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * ReviewsDeleteAllSpam command.
 */
class ReviewsDeleteAllSpamCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'reviews deleteAllSpam';
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
        $parser->setDescription('Delete all reviews marked as spam.');

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $reviewsTable = $this->fetchTable('Reviews');

        // Count spam reviews before deletion
        $spamCount = $reviewsTable->find()
            ->where(['is_spam' => 1])
            ->count();

        if ($spamCount === 0) {
            $io->info('No spam reviews found.');
            return static::CODE_SUCCESS;
        }

        $io->info("Found {$spamCount} spam review(s).");

        // Delete spam reviews
        $deleted = $reviewsTable->deleteAll(['is_spam' => 1]);

        if ($deleted) {
            $io->success("Successfully deleted {$deleted} spam review(s).");
            return static::CODE_SUCCESS;
        } else {
            $io->error('Failed to delete spam reviews.');
            return static::CODE_ERROR;
        }
    }
}