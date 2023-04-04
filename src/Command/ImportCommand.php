<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\Mailer\MailerAwareTrait;
use SoapClient;
use SoapHeader;

/**
 * Import command.
 */
class ImportCommand extends Command
{
    use MailerAwareTrait;

    protected $defaultTable = 'Imports';

    // YHN credentials for SOAP server
    protected $yourHearingNetwork = [
        'user'      => 'HealthyHearing',
        'pass'      => '98TY34!a',
        'wsdlUrl'   => 'https://ww2.yourhearingnetwork.com/External/Webservices/HHExtraction.asmx?wsdl',
        'authUrl'   => 'https://ww2.yourhearingnetwork.com/HealthyHearing',
    ];
    protected $yhnFilename = 'tmp/latestYhnImport.xml';

    // CQPartners credentials for REST web service
    protected $cqp = [
        'user' => "cq-parner-1SpbEO4egD3SdZ0pUNES",
        'pass' => "bhme8zCxbbFdhLMwqNnv",
        'url' => "https://bizlink.consultnavigator.com/crminformation/api/Practice/",
    ];

    // Used for tracking which locations changed tiers for reporting purposes.
    private $changedTiers = [];

    private $yhnLocations = [];
    private $newLocations = [];
    private $newProviders = [];
    private $oticonLocations = [];
    private $noZeroOticonLocations = [];
    private $cqpLocations = [];
    private $importId;
    private $previousImportId;
    private $io;
    private $bypass;

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
            ->setDescription('Import clinic data from specified group')
            ->addArgument('importType', [
                'help' => 'The type of import to run (YHN, CQP, ...)',
                'required' => true,
                'choices' => ['yhn', 'cqp'],
            ])
            ->addOption('bypass', [
                'short' => 'b',
                'help' => 'Bypass file download',
                'boolean' => true
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
        $this->io = $io;
        $importType = $args->getArgument('importType');
        $this->bypass = $args->getOption('bypass');
        $this->Imports = $this->fetchTable('Imports');
        $this->ImportLocations = $this->fetchTable('ImportLocations');
        $this->ImportProviders = $this->fetchTable('ImportProviders');
        $this->ImportLocationProviders = $this->fetchTable('ImportLocationProviders');
        $this->ImportDiffs = $this->fetchTable('ImportDiffs');
        $this->Providers = $this->fetchTable('Providers');
        $this->Locations = $this->fetchTable('Locations');
        $this->LocationProviders = $this->fetchTable('LocationProviders');
        $this->CallSources = $this->fetchTable('CallSources');

        $io->out("Importing clinic data from {$importType}...");

        switch ($importType) {
            case 'yhn':
                $this->yhn();
                break;
            case 'cqp':
                $this->cqp();
                break;
            case 'ca':
                $this->ca();
                break;
            default:
                $io->error('Invalid import type');
                break;
        }
    }

    /*
     *  Import YHN XML and parse it into our database.
     */
    public function yhn() {
        $io = $this->io;
        $io->helper('BaseShell')->title("Import from YHN");
        if (!Configure::read('isYhnImportEnabled')) {
            $io->error('YHN imports are disabled on this server.');
            exit;
        }
        $yhnStart = microtime(true);

        // Populate the YHN Locations, YHN Provider, and Oticon Location arrays for later use.
        $this->yhnLocations = $this->Locations->find('list', [
            'keyField' => 'id_yhn_location',
            'valueField' => 'id',
            'conditions' => ['id_yhn_location != ""'],
        ])->toArray();

        $this->setPreviousImportId('yhn');

        // Generate a new YHN Import row
        $newImport = $this->Imports->newEmptyEntity();
        $newImport->type = 'yhn';
        $this->importId = $this->previousImportId;
        $this->Imports->save($newImport);
        $this->importId = $newImport->id;

        $io->info('New import ID = ' . $this->importId);
        $io->info('Previous import ID = ' . $this->previousImportId);

        // Retrieve our data feed
        if ($this->bypass) {
            // Read most recent downloaded file
            $io->out('Bypassing file download. Reading local file: '.$this->yhnFilename);
            if (!file_exists($this->yhnFilename)) {
                $io->error('Unable to read file.');
                exit;
            }
            $dataFeed = file_get_contents($this->yhnFilename);
        } else {
            // Download a new file from YHN
            $dataFeed = $this->retrieveYhnXml();
        }
        if ($dataFeed === false) {
            $io->error('Unable to read file.');
            exit;
        }

        // Parse our data feed
        $yhnLogData = $this->parseYhnXml($dataFeed);

        // Save our provider & location total counts to import table.
        $this->Imports->patchEntity($newImport, $yhnLogData);
        $this->Imports->save($newImport);

        // Find changes between this import and last
        $this->findImportChanges();

        // Update is_retail flag for each location
        $this->updateRetailStatus();

        // Remove YHN designator from Locations that are no longer YHN
        $this->removedLocations($this->importId);

        // Calculate listing types for each location
        $this->Locations->calculateListingTypes($io);

        // End CallSource numbers that are no longer needed
        $this->CallSources->endInvalidCallSourceNumbers($io);
        $this->Locations->noShowLocations($io);
        $this->Locations->showClinicsWithActiveCS($io);

        // Update filters
        $this->Locations->updateAllFilters($io);

        // Create an email report
        $this->createReport($this->importId);

        $io->success('Import complete.');

        // Display verbose stats
        $yhnEnd = microtime(true);
        $yhnTime = number_format(($yhnEnd - $yhnStart), 2);
        $this->displayVerboseStats();
        $io->out();
        $io->out('Import Duration: ' . $yhnTime . 's');
    }

    /*
     *  Check database to find the ID of the previous import.
     */
    function setPreviousImportId($type) {
        $previousImport = $this->Imports->find('all', [
            'contain' => [],
            'order' => 'created DESC',
            'conditions' => [
                'Imports.type' => $type,
            ]
        ])->first();
        $this->previousImportId = !empty($previousImport->id) ? $previousImport->id : 0;
    }

    /*
     *  Display additional statistics if verbose mode is on
     */
    function displayVerboseStats() {
        $io = $this->io;
        $importData = $this->Imports->findById($this->importId)->first()->toArray();
        $io->helper('BaseShell')->title('Import statistics');
        foreach ($importData as $importKey => $importValue) {
            $importLabel = ucfirst(str_replace('_', ' ', $importKey));
            $importLabel = str_pad($importLabel, 20);
            $io->out(' ' . $importLabel . ':  ' . $importValue);
        }
    }

    /**
     * Retrieve the XML feed from YHN.
     *
     * @return string XML feed from YHN
     */
    function retrieveYhnXml() {
        $io = $this->io;
        $io->out('Retrieving XML from ' . $this->yourHearingNetwork['wsdlUrl']);

        $auth = [
             'User' => $this->yourHearingNetwork['user'],
             'Password' => $this->yourHearingNetwork['pass'],
        ];

        $soapClient = new SoapClient($this->yourHearingNetwork['wsdlUrl'], []);
        $soapHeader = new SoapHeader($this->yourHearingNetwork['authUrl'], 'Authentication', $auth, false);
        $soapClient->__setSoapHeaders($soapHeader);

        $xml = $soapClient->__soapCall('getDataFeed', []);
        $result = $xml->getDataFeedResult;
        if (empty($result)) {
            $io->error('Unexpected return from SOAP Server.');
            exit;
        } else {
            // Save a copy of the import result (for debugging)
            $file = new File($this->yhnFilename, true, 0644);
            $file->write($result);
            $file->close();
            return $result;
        }
    }

    /*
     *  Parse out the YHN data we got from the data feed.
     */ 
    function parseYhnXml($xml) {
        $io = $this->io;
        // Load the XML into objects
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $officesArray = json_decode($json, true);
        $officesArray = $officesArray['Offices'];

        // Set our variables for use by the parsing script
        $locationCount = 0;
        $providerCount = 0;

        $io->out('Parsing XML');
        $io->out(count($officesArray) . ' Locations');
        $io->out();

        // Loop through location data
        foreach ($officesArray as $office) {
            // Keep a count of how many locations we have
            $locationCount++;

            // Save this location to ImportLocations
            $officeData = [
                'import_id' => $this->importId,
                'id_external' => $office['OfficeID'],
                'id_oticon' => empty($office['OticonID']) ? null : $office['OticonID'],
                'title' => $office['PracticeName'],
                'subtitle' => $office['OfficeName'],
                'address' => $office['OfficeAddress1'],
                'address_2' => empty($office['OfficeAddress2']) ? null : $office['OfficeAddress2'],
                'city' => $office['OfficeCity'],
                'state' => $office['OfficeState'],
                'zip' => $office['OfficeZip'],
                'phone' => $office['OfficePhone'],
                'is_retail' => ($office['OneRetail'] == 'True') ? 1 : 0,
            ];

            // Attempt to match this location
            $locationInfo = $this->matchLocation($officeData);
            $officeData['location_id'] = $locationInfo['locationId'];
            $officeData['match_type'] = $locationInfo['method'];

            // Save YHN Location with the matched location ID
            $importLocationEntity = $this->ImportLocations->newEntity($officeData);
            if ($this->ImportLocations->save($importLocationEntity)) {
                // Retrieve the ID of the ImportLocation we just saved
                $yhnImportLocationId = $importLocationEntity->id;

                $locationId = $locationInfo['locationId'];
                if (!empty($locationId)) {
                    // Save the YHN Office ID to our database.
                    $location = $this->Locations->get($locationId);
                    if (empty($location->is_yhn)) {
                        $location->is_yhn = true;
                    }
                    if ($location->yhn_tier != 2) {
                        $location->yhn_tier = 2;
                    }
                    if (empty($location->id_yhn_location)) {
                        $io->out('Associated location ' . $locationId . ' with YHN location ' . $office['OfficeID']);
                        $location->id_yhn_location = $office['OfficeID'];
                        $location->review_needed = true;
                    }

                    // Calculate listing_type
                    $origListingType = $location->listing_type;
                    $newListingType = $this->Locations->calculateListingType($location); // This will save any changes
                    if ($origListingType != $newListingType) {
                        $io->out('Changing Location ' . $locationId . ' from listing type ' . $origListingType . ' to ' . $newListingType);
                        $this->changedTiers[] = $locationId;
                    }
                }

                // Loop through each Provider
                if (!empty($office['Providers']['ID'])) {
                    // If only 1 provider, make sure it's in a sub-array
                    $office['Providers'] = [0 => $office['Providers']];
                }
                foreach ($office['Providers'] as $provider) {
                    $externalId = $provider['ID'];

                    // Keep a count of how many unique providers we have.
                    $providerCount ++;

                    // Clean the email address
                    $email = empty($provider['ProviderEmail']) ? null : str_replace(" ", "", trim($provider['ProviderEmail']));

                    // Save this provider to yhn_providers
                    $yhnProviderData = [
                        'import_id' => $this->importId,
                        'id_external' => $externalId,
                        'first_name' => $provider['ProviderFName'],
                        'last_name' => $provider['ProviderLName'],
                        'email' => $email,
                        'aud_or_his' => $provider['ProviderAUDorHIS'],
                    ];

                    // Save the ImportProvider record to our database
                    $importProviderEntity = $this->ImportProviders->newEntity($yhnProviderData);
                    if ($this->ImportProviders->save($importProviderEntity)) {
                        $importProviderId = $importProviderEntity->id;
                        $providerMatch = $this->matchProvider($importProviderEntity, $locationId);

                        if (!empty($providerMatch['new'])) {
                            // We have this provider in our database, but didn't get it from YHN previously. Add the YHN data.
                            $providerEntity = $this->Providers->get($providerMatch['id']);
                            $providerEntity->id_yhn_provider = $externalId;
                            $providerEntity->aud_or_his = $importProviderEntity->aud_or_his;

                            if (empty($providerEntity->email)) {
                                $providerEntity->email = $importProviderEntity->email;
                            }

                            $this->Providers->save($providerEntity);
                        }
                        if (!empty($providerMatch['id'])) {
                            // We have gotten this provider from YHN previously.
                            $importProviderEntity = $this->ImportProviders->get($importProviderId);
                            $importProviderEntity->provider_id = $providerMatch['id'];
                            $this->ImportProviders->save($importProviderEntity);
                        }

                        // Save our association to the ImportLocationProvider table
                        $locationProviderData = [
                            'import_id'             => $this->importId,
                            'import_provider_id'    => $importProviderId,
                            'import_location_id'    => $yhnImportLocationId,
                        ];
                        $importLocationProviderEntity = $this->ImportLocationProviders->newEntity($locationProviderData);
                        $this->ImportLocationProviders->save($importLocationProviderEntity);
                    } else {
                        // Failed to save ImportProvider
                        $io->error('Failed to save ImportProvider entity');
                        $errors = print_r($importProviderEntity->getErrors(), true);
                        $io->out($errors);
                    }
                }
            } else {
                // Failed to save the ImportLocation data
                $io->error('Failed to save ImportLocation entity');
                $io->out($importLocationEntity['error']);
            }
        }

        // Set up our return data, unused right now.
        $yhnLogData = [
            'total_locations' => $locationCount,
            'new_locations' => count($this->newLocations),
            'total_providers' => $providerCount,
            'new_providers' => count($this->newProviders),
        ];

        return $yhnLogData;
    }

    /*
     *  Attempt to match the YHN location data provided to a current HH location already in the system, and return the location_id.
     */
    function matchLocation($locationData) {
        $yhnOfficeId = (string) $locationData['id_external'];

        // Check to see if we've matched this location previously.
        if (!empty($yhnOfficeId) && !empty($this->yhnLocations[$yhnOfficeId])) {
            // Return the location's ID
            $locationId = $this->yhnLocations[$yhnOfficeId];
            return ['method' => 0, 'locationId' => $locationId];
        }
        if (!Configure::read('isYhnAutoMatched')) {
            return ['method' => -1, 'locationId' => null];
        }

        $oticonId = (string) $locationData['oticon_id'];
        $trimmedYhnOticonId = ltrim($oticonId, '0');

        /*******
         * Method 1: Attempt to match on Oticon ID & Title
         ********/
        if (!empty($oticonId) && !empty($this->oticonLocations[$oticonId])) {
            $hhInfo     = $this->oticonLocations[$oticonId];
            $locationId = key($hhInfo);
            $title      = $hhInfo[$locationId];

            if (
                $this->stringMatch($title, $locationData['title']) || 
                $this->stringMatch($title, $locationData['subtitle'])
            ) {
                // Return the location's ID
                return ['method' => 1, 'locationId' => $locationId];
            }
        } 

        /*******
         * Method 2: Attempt to match on Oticon ID with no leading 0s
         ********/
        if (!empty($oticonId)) {
            $matchedLocation = null;

            // Check untrimmed YHN Oticon ID against a trimmed HH Oticon ID
            if (!empty($this->noZeroOticonLocations[$oticonId])) {
                $matchedLocation = $this->noZeroOticonLocations[$oticonId];
            }

            // Check trimmed YHN Oticon ID against an untrimmed HH Oticon ID
            if (!empty($this->oticonLocations[$trimmedYhnOticonId])) {
                $matchedLocation = $this->oticonLocations[$trimmedYhnOticonId];
            }

            // Check trimmed YHN Oticon ID against a trimmed HH Oticon ID
            if (!empty($this->noZeroOticonLocations[$trimmedYhnOticonId])) {
                $matchedLocation = $this->noZeroOticonLocations[$trimmedYhnOticonId];
            }

            if (!empty($matchedLocation)) {
                $locationId = key($matchedLocation);
                $title      = $matchedLocation[$locationId];

                if (
                    $this->stringMatch($title, $locationData['title']) || 
                    $this->stringMatch($title, $locationData['subtitle'])
                ) {
                    // Return the location's ID
                    return ['method' => 2, 'locationId' => $locationId];
                }
            }
        }

        /*******
         * Method 3: Attempt to match on Zip + Address 1 + Address 2
         ********/
        $matchedLocation = $this->Location->find('all', [
            'conditions' => [
                'AND' => [
                    'zip' => $locationData['zip'],
                    'address' => $locationData['address'],
                    'address_2' => $locationData['address_2'],
                    'listing_type !=' => Location::LISTING_TYPE_NONE,
                    'is_active' => 1,
                    'is_show' => 1,
                ],
            ],
        ])->first();
        if (!empty($matchedLocation)) {
            $locationId = $matchedLocation->id;
            return ['method' => 3, 'locationId' => $locationId];
        }

    }

    /*  
     *  Attempt to match the provider data to an existing provider in the HH database.
     */
    function matchProvider($importProvider, $locationId) {
        $externalId = $importProvider->id_external;

        // Attempt to match to an existing YHN Provider
        if (!empty($externalId) && !empty($locationId)) {
            $locationProviders = $this->LocationProviders->find('list', [
                'keyField' => 'id',
                'valueField' => 'provider_id',
                'conditions' => ['location_id' => $locationId]
            ])->toArray();
            if (!empty($locationProviders)) {
                $provider = $this->Providers->find('all', [
                    'conditions' => [
                        'id IN' => $locationProviders,
                        'id_yhn_provider' => $externalId
                    ]
                ])->first();
                if (!empty($provider->id)) {
                    return ['new' => false, 'id' => $provider->id];
                }
            }
        }

        // Attempt to match to an existing HH Provider
        if (!empty($locationId)) {
            $providerMatch = $this->LocationProviders->find('all', [
                'contain' => ['Providers'],
                'conditions' => [
                    'Providers.first_name' => $importProvider->first_name,
                    'Providers.last_name' => $importProvider->last_name,
                    'location_id' => $locationId,
                ],
            ])->first();
            if (!empty($providerMatch)) {
                return ['new' => true, 'id' => $providerMatch->provider_id];
            }
        }

        // No match found
        return false;
    }

    /*
     *  Find changes between this import and the previous import.
     */
    function findImportChanges() {
        $io = $this->io;
        $io->helper('BaseShell')->title('Finding import changes');

        if (empty($this->previousImportId)) {
            return false;
        }

        $locationsUpdated   = 0;
        $providersUpdated   = 0;
        $locationsNew       = 0;
        $providersNew       = 0;

        $importLocations = $this->ImportLocations->find('all', [
            'contain' => ['ImportLocationProviders.ImportProviders'],
            'conditions' => [
                'import_id' => $this->importId,
            ],
        ])->disableHydration()->toArray();
        $previousImportLocations = $this->ImportLocations->find('all', [
            'contain' => ['ImportLocationProviders.ImportProviders'],
            'conditions' => [
                'import_id' => $this->previousImportId,
            ]
        ])->disableHydration()->toArray();

        // Sort out the locations from the previous import, using the yhn Office ID as the array key
        $sortedPreviousLocations = [];
        $sortedPreviousProviders = [];
        foreach ($previousImportLocations as $previousImportLocation) {
            $previousExternalLocationId = $previousImportLocation['id_external'];


            // Sort out the provider information (by yhn provider ID as array key)
            foreach ($previousImportLocation['import_location_providers'] as $previousLocationProvider) {
                $previousExternalProviderId = $previousLocationProvider['import_provider']['id_external'];
                $sortedPreviousProviders[$previousExternalLocationId][$previousExternalProviderId] = $previousLocationProvider['import_provider'];
            }
            unset($previousImportLocation['import_location_providers']);
            $sortedPreviousLocations[$previousExternalLocationId] = $previousImportLocation;
        }

        $locationsChanged = 0;
        foreach ($importLocations as $importLocation) {
            // Flag for if we need to set 'review_needed' for this location.
            $diff = false;

            $externalLocationId = $importLocation['id_external'];

            // This location didn't exist last time.
            if (empty($sortedPreviousLocations[$externalLocationId])) {
                $importLocationEntity = $this->ImportLocations->get($importLocation->id);
                $importLocationEntity->is_new = 1;
                $this->ImportLocations->save($importLocationEntity);
                $locationsNew++;
                continue;
            }

            // We only care if this imported Location is related to an HH Location.
            $locationId = $importLocation['location_id'];
            if (empty($locationId)) {
                continue;
            }

            // Pull out the providers for this location
            $importProviders = $importLocation['import_location_providers'];
            unset($importLocation['import_location_providers']);

            $locationDiff = array_diff($importLocation, $sortedPreviousLocations[$externalLocationId]);

            // These will always be different, so remove them for the diffing.
            unset($locationDiff['id']);
            unset($locationDiff['import_id']);
            unset($locationDiff['match_type']);

            // Don't bother with Email or notes either
            unset($locationDiff['email']);
            unset($locationDiff['notes']);

            if (!empty($locationDiff)) {
                $locationsUpdated++;
                $diff = true;
                // Save Location Diff
                foreach ($locationDiff as $field => $value) {
                    $importDiff = $this->ImportDiffs->newEmptyEntity();
                    $importDiff->import_id = $this->importId;
                    $importDiff->model = 'Location';
                    $importDiff->id_model = $locationId;
                    $importDiff->field = $field;
                    $importDiff->value = $value;
                    $importDiff->review_needed = 1;
                    $this->ImportDiffs->save($importDiff);
                }
            }
            $importProviderIds = [];
            foreach ($importProviders as $importProvider) {
                $importProvider = $importProvider['import_provider'];
                $externalProviderId = $importProvider['id_external'];
                $importProviderIds[] = $externalProviderId;
                // New provider, did not exist last import.
                if (empty($sortedPreviousProviders[$externalLocationId][$externalProviderId])) {
                    $providersNew++;
                    $diff = true;
                    continue;
                }

                // We only care if this YHN provider is related to an HH provider.
                $providerId = $importProvider['provider_id'];
                if (empty($providerId)) {
                    continue;
                }

                $previousImportProvider = $sortedPreviousProviders[$externalLocationId][$externalProviderId];

                //TODO: these fields will be removed from future cakephp4 migrations. For now we need to unset them.
                unset($previousImportProvider['caqh_number']);
                unset($previousImportProvider['npi_number']);
                unset($previousImportProvider['licenses']);
                unset($importProvider['caqh_number']);
                unset($importProvider['npi_number']);
                unset($importProvider['licenses']);

                // These fields should be automatically saved to the provider and not marked as an import diff
                $providerEntity = $this->Providers->get($providerId);
                foreach (['aud_or_his'] as $field) {
                    $providerEntity->$field = $importProvider[$field];
                    $this->Providers->save($providerEntity);
                    unset($importProvider[$field]);
                }

                $providerDiff = array_diff($importProvider, $previousImportProvider);
                unset($providerDiff['id']);
                unset($providerDiff['import_id']);
                unset($providerDiff['provider_id']);

                if (!empty($providerDiff)) {
                    $providersUpdated++;
                    $diff = true;
                    foreach ($providerDiff as $field => $value) {
                        $importDiff = $this->ImportDiffs->newEmptyEntity();
                        $importDiff->import_id = $this->importId;
                        $importDiff->model = 'Provider';
                        $importDiff->id_model = $providerId;
                        $importDiff->field = $field;
                        $importDiff->value = $value;
                        $importDiff->review_needed = 1;
                        $this->ImportDiffs->save($importDiff);
                    }
                }

            }
            // Find any providers from previous imports that are not on this import
            $existingLocationProviders = $this->LocationProviders->find('all', [
                'contain' => ['Providers' => ['fields' => ['id_yhn_provider']]],
                'conditions' => [
                    'location_id' => $locationId
                ]
            ])->disableHydration()->all();
            foreach ($existingLocationProviders as $existingLocationProvider) {
                if (!empty($existingLocationProvider['provider']['id_yhn_provider'])) {
                    if (!in_array($existingLocationProvider['provider']['id_yhn_provider'], $importProviderIds)) {
                        // This provider came from a previous import, but is not in this import. Mark as needs_review.
                        $diff = true;
                    }
                }
            }
            if ($diff) {
                $locationsChanged++;
                $locationEntity = $this->Locations->get($locationId);
                $locationEntity->review_needed = 1;
                $this->Locations->save($locationEntity);
            }
        }

        // Save the import metrics
        $importEntity = $this->Imports->get($this->importId);
        $importEntity->new_locations = $locationsNew;
        $importEntity->new_providers = $providersNew;
        $importEntity->updated_locations = $locationsUpdated;
        $importEntity->updated_providers = $providersUpdated;
        $this->Imports->save($importEntity);

        return $locationsChanged;
    }

    /**
    *   Copy over Retail/OneRetail status from ImportLocations to Locations,
    *   based on yhn ID matching.
    */
    function updateRetailStatus() {
        $io = $this->io;
        // Only update is_retail flag if true. Do not overwrite is_retail if we have it set and YHN does not.
        $importLocations = $this->ImportLocations->find('all', [
            'contain' => 'Locations',
            'conditions' => [
                'import_id' => $this->importId,
                'ImportLocations.is_retail' => 1,
                'Locations.is_retail' => 0
            ]
        ])->all();
        $count = count($importLocations);
        foreach ($importLocations as $importLocation) {
            $locationEntity = $this->Locations->get($importLocation->location_id);
            $locationEntity->is_retail = true;
            $this->Locations->save($locationEntity);
        }
        $io->out("'is_retail' flag set for ".$count." locations.");
    }

    /*
     *  Remove Locations that were not in the last YHN Import.
     */
    function removedLocations() {
        $io = $this->io;
        // Get a list of all YHN Location IDs from the last import
        $importLocations = $this->ImportLocations->find('list', [
            'keyField' => 'id',
            'valueField' => 'id_external',
            'conditions' => [
                'import_id' => $this->importId
            ],
        ])->toArray();

        // Get a list of all current Locations that are YHN
        $currentLocations = $this->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'id_yhn_location',
            'conditions' => [
                'yhn_tier' => 2
            ],
        ])->toArray();

        // Determine which of the YHN Locations is no longer in the import
        $removedLocations = [];
        $countRemoved=0;
        $countNotRemoved=0;
        foreach ($currentLocations as $id => $yhnLocationId) {
            if (!in_array($yhnLocationId, $importLocations)) {
                $removedLocations[] = $id;
            }
        }

        // Set yhn tier data for each removed location
        foreach ($removedLocations as $locationId) {
            // Keep the id_yhn_location and the is_yhn flag, but set yhn_tier to 0
            $locationEntity = $this->Locations->get($locationId);
            $locationEntity->yhn_tier = 0;
            $this->Locations->save($locationEntity);
            $io->out('Location: ' . $locationId . ' is no longer a YHN Location.');
        }
        $io->out(count($removedLocations).' total locations have been removed from YHN import.');
    }

    /*
     *  Generate an Import Report
     */
    function createReport($importId = 0) {
        $io = $this->io;
        $io->helper('BaseShell')->title('Creating import report');

        if (empty($importId)) {
            $io->error('No import ID found.');
            return false;
        }

        $importData = $this->Imports->findById($this->importId)->first();
        if (empty($importData)) {
            $io->error('No data found for this import.');
            return false;
        }

        $body = '<style>table#import th { width: 40%; } table#import td, table#import th { border: solid 1px #000; padding: 5px; } table#import { min-width: 500px; border-collapse: collapse; }</style>';
        $body .= '<table id="import">';
        $body .= '<tr>';
        $body .= '<th>Import Time</th>';
        $body .= '<td>' . $importData->created->format('F d, Y \a\t g:i A') . '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
        $body .= '<th>Total Locations</th>';
        $body .= '<td>' . $importData->total_locations . '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
        $body .= '<th>Updated Locations</th>';
        $body .= '<td>' . $importData->updated_locations . '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
        $body .= '<th>New Locations</th>';
        $body .= '<td>' . $importData->new_locations . '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
        $body .= '<th>Total Providers</th>';
        $body .= '<td>' . $importData->total_providers . '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
        $body .= '<th>Updated Providers</th>';
        $body .= '<td>' . $importData->updated_providers . '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
        $body .= '<th>New Providers</th>';
        $body .= '<td>' . $importData->new_providers . '</td>';
        $body .= '</tr>';
        $body .= '</table>';

        $email = [];
        $email['body'] = $body;
        if (Configure::read('env') == 'prod') {
            $email['to'] = Configure::read('import-email');
        } else {
            $email['to'] = Configure::read('developerEmails');
        }
        $email['subject'] = strtoupper($importData->type) . ' Import - ' . date('F d, Y');
        if (Configure::read('env') != 'prod') {
            $email['subject'] = '('.Configure::read('env').') '.$email['subject'];
        }
        // Send email
        $this->getMailer('Admin')->send('importComplete', [$email]);
        $io->out('Import report email sent to '.implode(', ', $email['to']));
    }
}
