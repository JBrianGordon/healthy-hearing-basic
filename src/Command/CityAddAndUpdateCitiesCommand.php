<?php
declare(strict_types=1);

namespace App\Command;

use App\Utility\GeoLocAddressUtility;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;

/**
 * CityAddAndUpdateCities command.
 */
class CityAddAndUpdateCitiesCommand extends Command
{
    use MailerAwareTrait;

    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'city addAndUpdateCities';
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

        $parser->setDescription('Add new cities and update cities near locations');

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

        $locationsTable = TableRegistry::getTableLocator()->get('Locations');
        $citiesTable = TableRegistry::getTableLocator()->get('Cities');

        $locations = $locationsTable->find()
            ->where([
                'Locations.state IS NOT' => null,
                'Locations.state !=' => '',
                'Locations.city IS NOT' => null,
                'Locations.city !=' => '',
                'Locations.is_active' => true,
                'Locations.is_show' => true,
            ])
            ->select(['Locations.city', 'Locations.state', 'Locations.id'])
            ->disableHydration()
            ->toArray();

        $addCount = 0;
        $updateCountryCount = 0;
        $updateLatLonCount = 0;
        $nearLocationCount = 0;
        $formatCount = 0;
        $citiesAdded = [];
        $errors = [];

        // Clear all is_near_location flags
        $citiesTable->updateAll(
            ['is_near_location' => 0],
            [], // all rows in Cities table
        );

        $io->helper('Progress')->init(['total' => count($locations)]);
        $progress = $io->helper('Progress');

        foreach ($locations as $location) {
            $cityName = cleanCityName($location['city']);
            $stateName = $location['state'];

            if (!empty($stateName) && !empty($cityName)) {
                $city = $citiesTable->find()
                    ->where([
                        'Cities.city LIKE' => $cityName,
                        'Cities.state LIKE' => $stateName
                    ])
                    ->first();

                if (empty($city)) {
                    // City not found. Add it.
                    // It looks like the Cake 2 code also adds a city initially
                    // without lat/lon values. They should be added on a subsequent
                    // run of this script.
                    $cityEntity = $citiesTable->newEntity([
                        'city' => $cityName,
                        'state' => $stateName,
                        'country' => strtoupper(Configure::read('country', 'US')),
                        'is_near_location' => 1,
                    ]);

                        // Add lat/lon for new city.
                        try {
                            $addressGeocoder = new GeoLocAddressUtility();
                            $addressGeocoderResult = $addressGeocoder->byAddress("{$cityName}, {$stateName}");

                            if (!empty($addressGeocoderResult)) {
                                $cityEntity->lat = $addressGeocoderResult['lat'];
                                $cityEntity->lon = $addressGeocoderResult['lon'];
                            } else {
                                $io->error("Failed to find lat/lon for city: {$cityName}, {$stateName}");
                            }
                        } catch (\Exception $e) {
                            $io->error("Failed to find lat/lon for city: {$cityName}, {$stateName} - " . $e->getMessage());
                        }

                    if ($citiesTable->save($cityEntity)) {
                        $citiesAdded[] = "{$cityName}, {$stateName}";
                        $addCount++;
                    } else {
                        $errors[] = "Failed to add city: {$cityName}, {$stateName}";
                    }
                } else {
                    // City already exists. Update is_near_location flag and add any missing data.

                    if ($city->city !== $cityName) {
                        // City name is not formatted correctly
                        $city->city = $cityName;
                        $formatCount++;
                    }

                    if (empty($city->is_near_location)) {
                        $nearLocationCount++;
                    }

                    $city->is_near_location = true;

                    if (empty($city->country) && $this->isUs($stateName)) {
                        // Country is missing for this city. Add it.
                        $city->country = 'US';
                        $updateCountryCount++;
                    }

                    if (empty($city->lat) || empty($city->lon)) {
                        // Lat/lon is missing for this city. Add it.
                        try {
                            $addressGeocoder = new GeoLocAddressUtility();
                            $addressGeocoderResult = $addressGeocoder->byAddress("{$cityName}, {$stateName}");

                            if (!empty($addressGeocoderResult)) {
                                $city->lat = $addressGeocoderResult['lat'];
                                $city->lon = $addressGeocoderResult['lon'];
                                $updateLatLonCount++;
                            } else {
                                $io->error("Failed to find lat/lon for city: {$cityName}, {$stateName}");
                            }
                        } catch (\Exception $e) {
                            $io->error("Failed to find lat/lon for city: {$cityName}, {$stateName} - " . $e->getMessage());
                        }
                    }

                    $citiesTable->save($city);
                }
            } else {
                $io->error("Location {$location['id']} has invalid city/state: {$location['city']}, {$location['state']}");
            }

            $progress->increment(1)->draw();
        }

        $io->out('');
        $io->success("{$updateCountryCount} cities updated with country data");
        $io->success("{$updateLatLonCount} cities updated with lat/lon data");
        $io->success("{$formatCount} cities updated with correct city name format");
        $io->success("{$nearLocationCount} cities near locations");
        $io->success("{$addCount} new cities added to the database");

        if (!empty($citiesAdded)) {
            $env = Configure::read('env');

            $email = [];
            if ($env === 'prod') {
                $email['to'] = Configure::read('citiesAddedEmail');
            } else {
                $email['to'] = Configure::read('developerEmails');
            }

            $email['subject'] = "New cities added to database";
            $message = 'These new cities have been added to the database:<br><br>';

            foreach ($citiesAdded as $cityAdded) {
                $io->out($cityAdded);
                $message .= $cityAdded . '<br>';
            }

            $email['body'] = $message;
            // Send email
            $this->getMailer('Admin')->send('default', [$email]);
        }

        foreach ($errors as $error) {
            $io->error($error);
        }

        return static::CODE_SUCCESS;
    }
}
