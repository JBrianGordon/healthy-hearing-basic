<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * CityAddAndUpdateCitiesByRange command.
 */
class CityAddAndUpdateCitiesByRangeCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'city addAndUpdateCitiesByRange';
    }

    protected $defaultTable = 'Cities';

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

        $parser->setDescription('Add new cities and update near locations by range');

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
        $io->out('Add new cities and update cities near locations');

        $country = Configure::read('country');
        $minPopulation = ($country == 'US') ? 15000 : 5000;
        $io->out('Indexing cities within 15 miles of a clinic and population over '. number_format($minPopulation));

        $locationsTable = TableRegistry::getTableLocator()->get('Locations');
        $citiesTable = TableRegistry::getTableLocator()->get('Cities');

        // Find cities that are (is_near == false) with (population > 15,000 US [5,000 CA])
        $cities = $citiesTable->find()
            ->where([
                'is_near_location' => false,
                'country' => $country,
                'lon !=' => 0,
                'population >=' => $minPopulation,
            ])->all();

        $io->helper('Progress')->init(['total' => count($cities)]);
        $progress = $io->helper('Progress');

        foreach ($cities as $city) {
            $cityLatLon = [
                'lat' => $city['lat'],
                'lon' => $city['lon'],
            ];

            $locationConditions = [
                'is_active' => 1,
                'is_show' => 1,
            ];
            $locations = $locationsTable->findAllByGeoLoc($cityLatLon, 1, $locationConditions, [], [], 15);

            if (count($locations) > 0) {
                $cleanCityName = cleanCityName($city['city']);

                // Is a clean city name already in table?
                $lookupCity = $citiesTable->find()
                    ->where([
                        'city LIKE' => $cleanCityName,
                        'state LIKE' => $city['state'],
                    ])
                    ->first();

                if (empty($lookupCity)) {
                    $cityEntity = $citiesTable->newEntity([
                        'city' => $cleanCityName,
                        'state' => $city['state'],
                        'country' => strtoupper(Configure::read('country')),
                        'lat' => $city['lat'],
                        'lon' => $city['lon'],
                        'population' => $city['population'],
                        'is_near_location' => true,
                    ]);
                    $citiesTable->save($cityEntity);
                }

                // Skip to next city if lookup is already is_near
                if ($lookupCity['is_near_location'] === true) {
                    $progress->increment(1)->draw();
                    continue;
                }

                // Save this city as an is_near city.
                $lookupCity['is_near_location'] = true;
                $citiesTable->save($lookupCity);
            }

            $progress->increment(1)->draw();
        }

        $isNearCount = $citiesTable->find()
            ->where([
                'is_near_location' => true,
            ])->count();

        $io->out($io->nl(1));
        $io->hr();
        $io->out($isNearCount . ' cities have the is_near_location flag.');
    }
}
