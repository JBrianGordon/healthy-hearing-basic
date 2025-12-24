<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

class LocationsFindExpiredFeaturesCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'locations findExpiredFeatures';
    }

    protected $defaultTable = 'Locations';

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

        $parser->setDescription('Find and disable expired upgrade features');

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
        $io->out('Find and disable expired upgrade features');
        $io->hr();

        if (Configure::read('isTieringEnabled')) {
            // Find content library expirations
            $locations = $this->Locations->find('all', [
                'conditions' => [
                    'feature_content_library' => true,
                    'content_library_expiration <' => date('Y-m-d')
                ],
            ])->all();
            if (!empty($locations)) {
                foreach ($locations as $location) {
                    $io->out("Content library feature expired for ".$location->id);
                    $location->feature_content_library = false;
                    $location->content_library_expiration = null;
                    $this->Locations->save($location);
                    $noteBody = 'Content library feature expired.';
                    $this->Locations->LocationNotes->add($location->id, $noteBody);
                }
            }
            $io->success('Done. Content library feature expired for '.count($locations).' locations.');
        } else {
            $io->out('Skipping. Tiering is disabled.');
        }
        return static::CODE_SUCCESS;
    }
}
