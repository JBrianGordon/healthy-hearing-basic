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
class LocationsUnfreezeListingTypesCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'locations unfreezeListingTypes';
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

        $parser->setDescription('Unfreeze clinics with an expired frozen listing type');

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
        $io->out('Unfreeze clinics with an expired frozen listing type');
        $io->hr();

        if (Configure::read('isTieringEnabled')) {
            $locations = $this->Locations->find('all', [
                'conditions' => [
                    'is_listing_type_frozen' => true,
                    'frozen_expiration <' => date('Y-m-d')
                ],
            ])->all();
            if (!empty($locations)) {
                foreach ($locations as $location) {
                    $io->out("Frozen expired for ".$location->id);

                    $location->is_listing_type_frozen = false;
                    $location->frozen_expiration = null;
                    $this->Locations->save($location);
                    $this->Locations->calculateListingType($location->id);
                    $noteBody = 'Listing type no longer frozen (expired).';
                    $this->Locations->LocationNotes->add($location->id, $noteBody);
                }
                // End CS numbers for any locations that are no longer shown
                $this->Locations->CallSources->endInvalidCallSourceNumbers($io);
            }
            $io->success('Done. Listing types un-frozen for '.count($locations).' locations.');
        } else {
            $io->out('Skipping. Tiering is disabled.');
        }
        return static::CODE_SUCCESS;
    }
}