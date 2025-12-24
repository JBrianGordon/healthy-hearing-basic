<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

class LocationsEndGracePeriodsCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'locations endGracePeriods';
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

        $parser->setDescription('End grace periods for all expired T3 clinics');

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
        $io->out('Ending grace periods for all expired T3 clinics.');
        $io->hr();

        if (Configure::read('isTieringEnabled')) {
            $locations = $this->Locations->find('all', [
                'conditions' => [
                    'is_grace_period' => true,
                    'grace_period_end <=' => date('Y-m-d')
                ],
            ])->all();
            if (!empty($locations)) {
                foreach ($locations as $location) {
                    $io->out("Grace period expired for ".$location->id);
                    // End grace period and calculate new listing type
                    $location->is_grace_period = false;
                    $location->grace_period_end = null;
                    $this->Locations->save($location);
                    $this->Locations->calculateListingType($location->id);
                    // Add a note
                    $noteBody = 'End of grace period.';
                    $this->Locations->LocationNotes->add($location->id, $noteBody);
                }
                // End CS numbers for any locations that are no longer shown
                $this->Locations->CallSources->endInvalidCallSourceNumbers($io);
                $this->Locations->noShowLocations($io);
                $this->Locations->showClinicsWithActiveCS($io);
            }
            $io->success('Done. Grace periods ended for '.count($locations).' locations.');
        } else {
            $io->out('Skipping. Tiering is disabled.');
        }
        return static::CODE_SUCCESS;
    }
}