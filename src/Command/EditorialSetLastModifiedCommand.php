<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

/**
 * EditorialSetLastModified command.
 */
class EditorialSetLastModifiedCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'editorial setLastModified';
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

        $parser->setDescription('Set last_modified date for content items that are missing it');

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
        $io->out('Setting the last_modified date for all content items');
        $io->hr();
        
        if (!Configure::read('showReports')) {
            $io->warning('Skipping. Reports are disabled.');
            return static::CODE_SUCCESS;
        }

        $contentTable = $this->fetchTable('Content');
        
        // Find all content items with null last_modified
        $contents = $contentTable->find()
            ->select(['id', 'date'])
            ->where(['last_modified IS' => null])
            ->disableHydration()
            ->all();

        $total = $contents->count();
        
        if ($total === 0) {
            $io->success('No content items need updating.');
            return static::CODE_SUCCESS;
        }

        $io->out("Found {$total} content items to update");
        
        $count = 0;
        $errors = [];
        
        foreach ($contents as $content) {
            $entity = $contentTable->get($content['id']);
            $entity->last_modified = $content['date'];
            
            if ($contentTable->save($entity)) {
                $count++;
                $io->out('.', 0); // Output progress without newline
            } else {
                $errors[] = $content['id'];
                $io->out('E', 0); // Output error indicator
            }
        }
        
        $io->out(); // New line after progress indicators
        $io->hr();
        
        if (!empty($errors)) {
            $io->error("Errors occurred with the following content IDs:");
            foreach ($errors as $errorId) {
                $io->out("  - {$errorId}");
            }
        }
        
        $io->success("Finished. Last modified date updated for {$count} of {$total} content items.");
        
        return static::CODE_SUCCESS;
    }
}