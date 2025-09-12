<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\Location;
use App\Model\Entity\ImportStatus;
use App\Enums\Model\Review\ReviewOrigin;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\Mailer\MailerAwareTrait;
use Cake\Validation\Validation;
use SoapClient;
use SoapHeader;
use DOMDocument;

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
    protected $cqpFilename = 'tmp/latestCqpImport.xml';

    // Credentials for Canadian sftp server
    protected $canadianServer = [
        'username'  => 'HearingAssist',
        'password'  => 'Listen123',
        'url'       => 'sftp.us.dgs.com',
    ];
    protected $caLocationFile = 'tmp/latestCaLocationImportFile.xml';
    protected $caProviderFile = 'tmp/latestCaProviderImportFile.xml';

    // Credentials for Oticon sftp server
    protected $oticonServer = [
        'url' => 'sftp.us.dgs.com',
        'username' => 'HealthyHearing',
        'password' => 'm6@BYJ@j[Mkj[n*#'
    ];
    protected $oticonFilename = 'tmp/latestOticonImport.csv';

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
                'help' => 'The type of import to run (YHN, CQP, CA, OTICON...)',
                'required' => true,
                'choices' => ['yhn', 'cqp', 'ca', 'oticon'],
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
        $this->LocationsProviders = $this->fetchTable('LocationsProviders');
        $this->CallSources = $this->fetchTable('CallSources');
        $this->ImportStatus = $this->fetchTable('ImportStatus');
        $this->LocationNotes = $this->fetchTable('LocationNotes');

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
            case 'oticon':
                $this->oticon();
                break;
            default:
                $io->error('Invalid import type');
                break;
        }
    }

    /***************************************************
     * YHN
     * *************************************************/

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

        // Populate list of YHN and Oticon locations for later use.
        $this->yhnLocations = $this->Locations->find('list', [
            'keyField' => 'id_yhn_location',
            'valueField' => 'id',
            'conditions' => ['id_yhn_location != ""'],
        ])->toArray();
        $this->oticonLocations = $this->Locations->find('list', [
            'keyField' => 'id_oticon',
            'valueField' => 'id',
            'conditions' => [
                'id_oticon !=' => '""',
                'listing_type !=' => Location::LISTING_TYPE_NONE,
                'is_active' => 1,
                'is_show' => 1,
            ],
        ])->toArray();
        // Create a version without preceding zeros
        foreach ($this->oticonLocations as $idOticon => $locationId) {
            $idOticon = ltrim((string)$idOticon, '0');
            $this->noZeroOticonLocations[$idOticon] = $locationId;
        }

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

        // Add CallSource numbers if needed
        $this->Locations->addCallSourceNumbers($io);
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
        $importData = $this->Imports->get($this->importId)->toArray();
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
            $locationInfo = $this->matchYhnLocation($officeData);
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
                        pr($importProviderEntity);
                        exit;
                    }
                }
            } else {
                // Failed to save the ImportLocation data
                $io->error('Failed to save ImportLocation entity');
                $io->out($importLocationEntity['error']);
                pr($importLocationEntity);
                exit;
            }
        }

        // Set up our return data
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
    function matchYhnLocation($locationData) {
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

        $oticonId = (string) $locationData['id_oticon'];
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
        $matchedLocation = $this->Locations->find('all', [
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
            $locationsProviders = $this->LocationsProviders->find('list', [
                'keyField' => 'id',
                'valueField' => 'provider_id',
                'conditions' => ['location_id' => $locationId]
            ])->toArray();
            if (!empty($locationsProviders)) {
                $provider = $this->Providers->find('all', [
                    'conditions' => [
                        'id IN' => $locationsProviders,
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
            $providerMatch = $this->LocationsProviders->find('all', [
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
                $importLocationEntity = $this->ImportLocations->get($importLocation['id']);
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
                // New provider, did not exist last import
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
            $existingLocationsProviders = $this->LocationsProviders->find('all', [
                'contain' => ['Providers' => ['fields' => ['id_yhn_provider']]],
                'conditions' => [
                    'location_id' => $locationId
                ]
            ])->disableHydration()->all();
            foreach ($existingLocationsProviders as $existingLocationsProvider) {
                if (!empty($existingLocationsProvider['provider']['id_yhn_provider'])) {
                    if (!in_array($existingLocationsProvider['provider']['id_yhn_provider'], $importProviderIds)) {
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
        // Send email
        $this->getMailer('Admin')->send('default', [$email]);
        $io->out('Import report email sent to '.implode(', ', $email['to']));
    }

    /***************************************************
     * CQP
     * *************************************************/

    /*
     *  Import CQPartners XML and parse it into our database.
     */
    function cqp() {
        $io = $this->io;
        $io->helper('BaseShell')->title("CQ Partners Import");
        if (!Configure::read('isCqpImportEnabled')) {
            $io->error('CQP imports are disabled on this server.');
            return;
        }
        if(!function_exists('curl_init')) {
            $io->error("Error: Curl is not installed on this server");
        }

        $cqpStart = microtime(true);
        $this->setPreviousImportId('cqp');

        // Populate list of CQP locations for later use
        $this->cqpLocations = $this->Locations->find('list', [
            'keyField' => 'id_cqp_office',
            'valueField' => 'id',
            'conditions' => ['id_cqp_office != ""'],
        ])->toArray();

        // Generate a new CQP Import row
        $newImport = $this->Imports->newEmptyEntity();
        $newImport->type = 'cqp';
        $this->importId = $this->previousImportId;
        $this->Imports->save($newImport);
        $this->importId = $newImport->id;

        $io->info('New import ID = ' . $this->importId);
        $io->info('Previous import ID = ' . $this->previousImportId);

        // Retrieve our data feed
        if ($this->bypass) {
            // Read most recent downloaded file
            $io->out('Bypassing file download. Reading local file: '.$this->cqpFilename);
            if (!file_exists($this->cqpFilename)) {
                $io->error('Unable to read file.');
                exit;
            }
            $dataFeed = file_get_contents($this->cqpFilename);
        } else {
            // Download a new file from CQP
            $dataFeed = $this->retrieveCqpXml();
        }
        if ($dataFeed === false) {
            $io->error('Unable to read file.');
            exit;
        }

        // Parse our data feed
        $cqpLogData = $this->parseCqpXml($dataFeed);

        // Save our location counts to import table
        $this->Imports->patchEntity($newImport, $cqpLogData);
        $this->Imports->save($newImport);

        // Find changes between this import and last
        $this->findCqpImportChanges();

        // Remove cqp_tier from locations that are no longer in the import
        $this->removedCqpLocations($this->importId);

        // Calculate listing types for each location
        $this->Locations->calculateListingTypes($io);

        // Add CallSource numbers if needed
        $this->Locations->addCallSourceNumbers($io);
        // End CallSource numbers that are no longer needed
        $this->CallSources->endInvalidCallSourceNumbers($io);
        $this->Locations->noShowLocations($io);
        $this->Locations->showClinicsWithActiveCS($io);

        // Update filters
        $this->Locations->updateAllFilters($io);

        // Create an email report
        $this->createReport($this->importId);

        $io->success('Import complete.');

        // Show stats
        $cqpEnd = microtime(true);
        $cqpTime = number_format(($cqpEnd - $cqpStart), 2);
        $this->displayVerboseStats();
        $io->out();
        $io->out('Import Duration: ' . $cqpTime . 's');
    }

    /*
     *  Retrieve the XML feed from CQP.
     */
    function retrieveCqpXml() {
        $io = $this->io;
        $io->out('Retrieving XML file from CQP');

        $post = [
            "UserName" => $this->cqp['user'],
            "Password" => $this->cqp['pass']
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_URL, $this->cqp['url']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept-Type: application/json'
        ]);

        $result = curl_exec($curl);
        curl_close($curl);

        if (empty($result)) {
            $io->error('Failed to get import file from CQP web server.');
            exit;
        } else {
            // Convert the result from string to proper XML format
            $dom = new DOMDocument;
            $dom->loadXML($result);
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $xmlResult = $dom->saveXML();
            // Save a copy of the import result (for debugging)
            $file = new File($this->cqpFilename, true, 0644);
            $file->write($xmlResult);
            $file->close();
            // Reformat as SimpleXMLElement
            $xmlData = simplexml_load_string($xmlResult);
            return $xmlData;
        }
    }

    /*
     *  Parse out the CQP data we got from the data feed.
     */
    function parseCqpXml($xml) {
        $io = $this->io;
        // Convert XML data to array format
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        }
        $xml = json_decode(json_encode($xml), true);
        // Set our variables for use by the parsing script
        $practiceCount      = 0;
        $locationCount      = 0;
        $newLocationCount   = 0;
        $missingPhoneCount  = 0;
        $missingEmailCount  = 0;
        $invalidEmailCount  = 0;

        $io->out('Parsing XML');
        $io->out(count($xml['Practice']) . ' Practices');

        // Loop through practice data
        foreach ($xml['Practice'] as $practice) {
            $practiceCount++;
            if ($practice['PracticeID'] == 'H6790') {
                // Ignore HearingLife
                pr('Warning: Ignoring practice H6790 (HearingLife).');
                continue;
            }
            if (!empty($practice['Offices']['Office']) && !isset($practice['Offices']['Office'][0])) {
                // Only 1 office. Map it to key=0.
                $practice['Offices']['Office'] = [0 => $practice['Offices']['Office']];
            }
            if (!isset($practice['Offices']['Office'])) {
                $practice['Offices']['Office'] = [];
            }
            if (!empty($practice['Contacts']['Contact']) && !isset($practice['Contacts']['Contact'][0])) {
                // Only 1 contact. Map it to key=0.
                $practice['Contacts']['Contact'] = [0 => $practice['Contacts']['Contact']];
            }
            foreach ($practice['Offices']['Office'] as $office) {
                $locationCount++;
                unset($importLocationData);
                // Collect data for this office
                $importLocationData = [
                    'import_id' => $this->importId,
                    'id_external' => '',
                    'id_cqp_practice' => $practice['PracticeID'],
                    'id_cqp_office' => $office['OfficeID'],
                    'title' => $practice['PracticeName'],
                    'subtitle' => $office['OfficeName'],
                    'address' => $office['OfficeAddress1'],
                    'address_2' => $office['OfficeAddress2'],
                    'city' => $office['OfficeCity'],
                    'state' => $office['OfficeState'],
                    'zip' => $office['OfficeZip'],
                    'phone' => $office['OfficePhone'],
                    'email' => $office['OfficeEmail'],
                ];
                if (empty($office['OfficePhone'])) {
                    pr('Warning: Office '.$office['OfficeID'].' ('.$office['OfficeName'].') has no phone and will not be included.');
                    $missingPhoneCount++;
                    continue;
                }
                if (empty($office['OfficeEmail'])) {
                    $importLocationData['email'] = '';
                    $missingEmailCount++;
                } elseif (!Validation::email($office['OfficeEmail'])) {
                    $importLocationData['email'] = '';
                    $invalidEmailCount++;
                }
                foreach ($importLocationData as $field => $value) {
                    // All fields should be formatted as string
                    if (empty($value)) {
                        $importLocationData[$field] = '';
                    } else if (is_array($value)) {
                        pr('Error invalid data for practice '.$practice['PracticeID'].', field '.$field);
                        pr($value);
                    }
                }

                // Add a note that includes all contact data for this practice
                if (!empty($practice['Contacts']['Contact'])) {
                    foreach ($practice['Contacts']['Contact'] as $contact) {
                        $importLocationData['notes'] = json_encode($practice['Contacts']['Contact']);
                    }
                }

                // Attempt to match this location.
                $locationInfo = $this->matchCqpLocation($importLocationData);
                $importLocationData['location_id']  = $locationInfo['locationId'];
                $importLocationData['match_type']   = $locationInfo['method'];

                // Save ImportLocation with the matched location ID
                $importLocationEntity = $this->ImportLocations->newEntity($importLocationData);
                if ($importLocationEntity->getErrors()) {
                    $io->error('Failed to save ImportLocation');
                    $io->error(print_r($importLocationEntity->getErrors(), true));
                    pr($importLocationEntity);
                    exit;
                }
                $this->ImportLocations->save($importLocationEntity);

                $locationId = $locationInfo['locationId'];
                if (!empty($locationId)) {
                    // We found a matching location for this CQP office
                    $locationEntity = $this->Locations->get($locationId);
                    $locationEntity->is_cqp = true;
                    $locationEntity->cqp_tier = 2;
                    $locationEntity->id_cqp_practice = $practice['PracticeID'];
                    if ($locationEntity->id_cqp_office != $office['OfficeID']) {
                        $io->out('Associated Location ' . $locationId . ' with CQP office ' . $office['OfficeID']);
                        $locationEntity->id_cqp_office = $office['OfficeID'];
                        $locationEntity->review_needed = 1;
                    }
                    $this->Locations->save($locationEntity);

                    // Calculate listing_type
                    $origListingType = $locationEntity->listing_type;
                    $newListingType = $this->Locations->calculateListingType($locationId);
                    if ($origListingType != $newListingType) {
                        $io->out('Changing Location ' . $locationId . ' from listing type ' . $origListingType . ' to ' . $newListingType);
                        $this->changedTiers[] = $locationId;
                    }
                } else {
                    // No match found
                    $newLocationCount++;
                }
            }
        }

        // Print some stats about our data quality
        $io->out('total practices = '.$practiceCount);
        $io->out('total locations = '.$locationCount);
        $io->out('missingPhoneCount = '.$missingPhoneCount);
        $io->out('missingEmailCount = '.$missingEmailCount);
        $io->out('invalidEmailCount = '.$invalidEmailCount);

        // Set up our return data, unused right now.
        $cqpLogData = [
            'total_locations' => $locationCount,
            'new_locations' => $newLocationCount
        ];
        return $cqpLogData;
    }

    /*
     *  Attempt to match the CQP location data provided to a current HH location already in the system, and return the location_id.
     */
    function matchCqpLocation($locationData) {
        $cqpOfficeId = $locationData['id_cqp_office'];

        /*******
         * Method 6: Attempt to match on id_cqp_office
         ********/
        if (!empty($cqpOfficeId) && !empty($this->cqpLocations[$cqpOfficeId])) {
            // Return the location's ID
            $locationId = $this->cqpLocations[$cqpOfficeId];
            return ['method' => 6, 'locationId' => $locationId];
        }

        /*******
         * Method -1: Auto matching is disabled
         ********/
        return ['method' => -1, 'locationId' => null];
    }

    /*
     *  Find changes between this import and the previous import.
     */
    function findCqpImportChanges() {
        $io = $this->io;
        $io->helper('BaseShell')->title('Finding CQP import changes');

        if (empty($this->previousImportId)) {
            return false;
        }

        $locationsUpdated   = 0;
        $locationsNew       = 0;

        $cqpLocations = $this->ImportLocations->find('all', [
            'contain' => [],
            'conditions' => [
                'import_id' => $this->importId,
            ],
        ])->all();
        $previousCqpLocations = $this->ImportLocations->find('all', [
            'contain' => [],
            'conditions' => [
                'import_id' => $this->previousImportId,
            ],
        ])->all();

        // Sort out the locations from the previous import, using the CQP office ID as the array key
        $sortedPreviousLocations = [];
        foreach ($previousCqpLocations as $previousCqpLocation) {
            $previousCqpOfficeId = $previousCqpLocation->id_cqp_office;
            $sortedPreviousLocations[$previousCqpOfficeId] = $previousCqpLocation;
        }

        $locationsChanged = 0;
        foreach ($cqpLocations as $cqpLocation) {
            // Flag for if we need to set 'review_needed' for this location.
            $diff = false;

            $cqpOfficeId = $cqpLocation->id_cqp_office;

            // This location didn't exist last time.
            if (empty($sortedPreviousLocations[$cqpOfficeId])) {
                $cqpLocation->is_new = 1;
                $this->ImportLocations->save($cqpLocation);
                $locationsNew++;
                continue;
            }

            $locationId = $cqpLocation->location_id;
            if (empty($locationId)) {
                // If this CQP location is not related to an HH location, then we don't need to diff
                continue;
            }

            $previousCqpLocation    = $sortedPreviousLocations[$cqpOfficeId];
            $locationDiff           = array_diff($cqpLocation->toArray(), $previousCqpLocation->toArray());

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
            if ($diff) {
                $locationsChanged++;
                $locationEntity = $this->Locations->get($locationId);
                $locationEntity->review_needed = 1;
                $this->Locations->save($locationEntity);
            }
        }

        $importEntity = $this->Imports->get($this->importId);
        $importEntity->new_locations = $locationsNew;
        $importEntity->updated_locations = $locationsUpdated;
        $this->Imports->save($importEntity);

        // Clear out the large arrays to free up memory
        unset($sortedPreviousLocations);
        unset($previousCqpLocations);
        unset($cqpLocations);

        $io->out("Found ".$locationsChanged." locations with changes since last import");
        return $locationsChanged;
    }

    /*
     *  Remove Locations that were not in the last CQP Import
     */
    function removedCqpLocations($importId = 0) {
        $io = $this->io;
        $io->helper('BaseShell')->title('Find locations that are no longer in CQP import');
        $count = 0;
        if (empty($importId)) {
            $io->error('Import ID is required.');
            return false;
        }

        // Get a list of all CQP office IDs from the last import
        $importLocations = $this->ImportLocations->find('list', [
            'keyField' => 'location_id',
            'valueField' => 'id_cqp_office',
            'conditions' => [
                'import_id' => $importId,
                'location_id IS NOT NULL'
            ],
        ])->toArray();

        // Get a list of all current Locations that are CQP
        $currentLocations = $this->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'id_cqp_office',
            'conditions' => [
                'id_cqp_office !=' => ''
            ],
        ])->toArray();

        // Determine which of the CQP Locations is no longer in the import
        $removedLocations = [];
        foreach ($currentLocations as $locationId => $cqpOfficeId) {
            if (!in_array($cqpOfficeId, $importLocations)) {
                $removedLocations[] = $locationId;
            }
        }

        // Set CQP tier data for each removed location
        foreach ($removedLocations as $locationId) {
            $location = $this->Locations->get($locationId);
            if ($location->cqp_tier != 0) {
                $count++;
                // Keep the id_cqp_office, id_cqp_practice and the is_cqp flag, but set cqp_tier to 0
                $location->cqp_tier = 0;
                $this->Locations->save($location);
                $this->Locations->calculateListingType($locationId);
                $io->out('Location: ' . $locationId . ' is no longer a CQP Location.');
            }
        }
        $io->out($count." locations are no longer in the CQP import");
    }

    /***************************************************
     * CA
     * *************************************************/

    /*
     *  Import YHN XML and parse it into our database.
     */
    public function ca() {
        $io = $this->io;
        $io->helper('BaseShell')->title("Import for HearingDirectory CA");
        if (Configure::read('country') != 'CA') {
            $io->error('CA imports are disabled on this server.');
            exit;
        }
        $startTime = microtime(true);
        $this->setPreviousImportId('ca');

        // Generate a new CA Import row
        $newImport = $this->Imports->newEmptyEntity();
        $newImport->type = 'ca';
        $this->importId = $this->previousImportId;
        $this->Imports->save($newImport);
        $this->importId = $newImport->id;

        $io->info('New import ID = ' . $this->importId);
        $io->info('Previous import ID = ' . $this->previousImportId);

        // Retrieve our data feed
        if ($this->bypass) {
            // Read most recent downloaded file
            $io->out('Bypassing file download. Reading local files: '.$this->caLocationFile.' and '.$this->caProviderFile);
            if (!file_exists($this->caLocationFile)) {
                $io->error('Unable to read file '.$this->caLocationFile);
                exit;
            }
            if (!file_exists($this->caProviderFile)) {
                $io->error('Unable to read file '.$this->caProviderFile);
                exit;
            }
        } else {
            // Download new location and provider import files
            $io->helper('BaseShell')->sftpRetrieveFile(
                $this->canadianServer['url'],
                $this->canadianServer['username'],
                $this->canadianServer['password'],
                'Clinic List.xml',
                $this->caLocationFile
            );
            $io->helper('BaseShell')->sftpRetrieveFile(
                $this->canadianServer['url'],
                $this->canadianServer['username'],
                $this->canadianServer['password'],
                'Provider List.xml',
                $this->caProviderFile
            );
        }
        // Parse and process our locations
        $fileContent = utf8_encode(file_get_contents($this->caLocationFile));
        $locations = simplexml_load_string($fileContent);
        $locations = json_encode($locations);
        $locations = str_replace("{}", '""', $locations); // Convert empty arrays to empty strings
        $locations = json_decode($locations, true);
        if (empty($locations)) {
            $io->error('No locations found in import file.');
            return false;
        }
        $caLogData = $this->parseCaLocations($locations);
        unset($locations);
        // Save our location total counts to import table.
        $this->Imports->patchEntity($newImport, $caLogData);
        $this->Imports->save($newImport);

        // Parse and process our providers
        $fileContent = utf8_encode(file_get_contents($this->caProviderFile));
        $providers = simplexml_load_string($fileContent);
        $providers = json_decode(json_encode($providers), true);
        if (empty($providers)) {
            $io->error('No providers found in import file.');
            return false;
        }
        $caLogData = $this->parseCaProviders($providers);
        unset($providers);
        // Save our provider total counts to import table.
        $this->Imports->patchEntity($newImport, $caLogData);
        $this->Imports->save($newImport);

        // Find changes between this import and last
        $this->findImportChanges();

        //TODO: This is done in yhn import, but not CA. I don't think we need it for CA, but need to verify
        // Update is_retail flag for each location
        //$this->updateRetailStatus();

        // Set locations that are no longer in the import as inactive.
        $this->removedCaLocations();

        // Calculate listing types for each location
        $this->Locations->calculateListingTypes($io);

        // Add CallSource numbers if needed
        $this->Locations->addCallSourceNumbers($io);
        // End CallSource numbers that are no longer needed
        $this->CallSources->endInvalidCallSourceNumbers($io);
        $this->Locations->noShowLocations($io);
        $this->Locations->showClinicsWithActiveCS($io);

        // Update filters
        $this->Locations->updateAllFilters($io);

        $this->createReport($this->importId);

        $io->success('Import complete.');

        // Display verbose stats
        $endTime = microtime(true);
        $totalTime = number_format(($endTime - $startTime), 2);
        $this->displayVerboseStats();
        $io->out();
        $io->out('Import Duration: ' . $totalTime . 's');
    }

    /*
     *  Remove Locations that were not in the last CA Import
     *  TODO: I think this is the same as removedLocations(). Can we use same function for YHN and CA?
     */
    function removedCaLocations() {
        $io = $this->io;
        // Get a list of all CA Location IDs from the last import
        $importLocations = $this->ImportLocations->find('list', [
            'keyField' => 'id',
            'valueField' => 'id_external',
            'conditions' => [
                'import_id' => $this->importId
            ],
        ])->toArray();

        // Get a list of all current Locations that are CA (yhn_tier=2)
        $currentLocations = $this->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'id_yhn_location',
            'conditions' => [
                'yhn_tier' => 2
            ],
        ])->toArray();

        // Determine which of the CA Locations is no longer in the import
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
            // Keep the id_yhn_location, but set yhn_tier to 0
            $locationEntity = $this->Locations->get($locationId);
            $locationEntity->yhn_tier = 0;
            $this->Locations->save($locationEntity);
            $io->out('Location: ' . $locationId . ' is no longer a CA Location.');
        }
        $io->out(count($removedLocations).' total locations have been removed from CA import.');
    }

    function parseCaLocations($locations) {
        $io = $this->io;
        $io->info('Parsing Locations ..');
        $io->out(count($locations['ClinicItem']).' locations found in import file.');
        $newCount=0;
        $spacesInExternalId = false;
        $spacesCount=0;
        foreach ($locations['ClinicItem'] as $location) {
            $externalId = (string)$location['LocationID'] ? (string)$location['LocationID'] : (string)$location['OticonID'];
            $externalId = filter_var($externalId, FILTER_SANITIZE_SPECIAL_CHARS);
            $externalId = trim(str_replace("&nbsp;", '', htmlentities($externalId)));
            // Clean special characters from email
            $email = filter_var($location['Email'], FILTER_SANITIZE_EMAIL);
            $saveData = [
                'import_id' => $this->importId,
                'id_external' => $externalId,
                'title' => trimIfString($location['Title']),
                'subtitle' => trimIfString($location['Subtitle']),
                'address' => trimIfString($location['Address1']),
                'address_2' => trimIfString($location['Address2']),
                'city' => trimIfString($location['City']),
                'state' => trimIfString($location['State']),
                'zip' => trimIfString($location['Zip']),
                'phone' => trimIfString($location['Phone']),
                'email' => trimIfString($email),
                'is_retail' => $location['is_retail'] == 'Yes' ? 1 : 0,
                'id_oticon' => (string)$location['OticonID'],
                'listing_type' => Location::LISTING_TYPE_ENHANCED,
                'is_call_assist' => false
            ];

            // Attempt to match this location.
            $locationMatch = $this->Locations->find('all', [
                'contain' => [],
                'fields' => ['id', 'id_yhn_location'],
                'conditions' => ['id_yhn_location' => $externalId]
            ])->first();

            // Check for nbsp and regular spaces in external ID for clinics already in the dB
            if (!empty($locationMatch)) {
                if (preg_match('/[\xC2\xA0 ]/', $locationMatch->id_yhn_location)) {
                    $locationMatch = [];
                    $spacesInExternalId = true;
                    $spacesCount++;
                }
            }

            // Check for nbsp and regular spaces in external ID values in the import file
            if (preg_match('/[\xC2\xA0 ]/', $externalId)) {
                $this->info('External ID ' . $externalId . ' has spaces!');
            }

            if (empty($locationMatch) && $spacesInExternalId == false) {
                // Check for id_yhn_location that is missing leading zeros
                $noLeadingZeros = ltrim($externalId, '0');
                $locationMatch = $this->Locations->find('all', [
                    'contain' => [],
                    'fields' => ['id', 'id_yhn_location'],
                    'conditions' => ['id_yhn_location' => $noLeadingZeros]
                ])->first();
                if (!empty($locationMatch)) {
                    $io->out('Found and updating a location without leading zeros: '.$locationMatch->id.': '.$locationMatch->id_yhn_location.' -> '.$externalId);
                    $locationEntity = $this->Locations->get($locationMatch->id);
                    $locationEntity->id_yhn_location = $externalId;
                    $this->Locations->save($locationEntity);
                }
            }

            if (!empty($locationMatch)) {
                $locationEntity = $this->Locations->get($locationMatch->id);
                $locationEntity->yhn_tier = 2;
                $this->Locations->save($locationEntity);
                $saveData['location_id'] = $locationMatch->id;
                $saveData['match_type'] = 1;
            } else {
                $newCount++;
                if ($location->is_retail == 'Yes') {
                    $io->out('New retail location = '.$externalId);
                } else {
                    $io->out('New Oticon location = '.$externalId);
                }
            }

            // Save CA Location with the matched location ID.
            $importLocationEntity = $this->ImportLocations->newEntity($saveData);
            if ($importLocationEntity->getErrors()) {
                $io->error('Failed to save ImportLocation');
                $io->error(print_r($importLocationEntity->getErrors(), true));
                pr($importLocationEntity);
                exit;
            }
            $importLocation = $this->ImportLocations->save($importLocationEntity);

            // Retrieve the ID of the Location we just saved
            $this->importLocations[$externalId] = $importLocationEntity->id;
        }
        $io->out($newCount.' new locations.');
        $io->out($spacesCount.' existing locations contained a space.');
        // Set up our return data
        $caLogData = [
            'total_locations' => count($locations['ClinicItem']),
            'new_locations' => $newCount,
        ];
        return $caLogData;
    }

    function parseCaProviders($providers) {
        $io = $this->io;
        $io->info('Parsing Providers ..');
        $io->out(count($providers['ProviderItem']).' providers found in import file.');

        $existingProviders = $this->Providers->find('list', [
            'keyField' => 'id_yhn_provider',
            'valueField' => 'id',
            'conditions' => ['id_yhn_provider != ""'],
        ])->toArray();
        $newCount = 0;

        foreach ($providers['ProviderItem'] as $provider) {
            $email = filter_var($provider['Email'], FILTER_SANITIZE_EMAIL);
            $externalId = trim($provider['ProviderID']);
            $saveData = [
                'import_id' => $this->importId,
                'first_name' => trim($provider['FirstName']),
                'last_name' => trim($provider['LastName']),
                'email' => $email,
                'id_external' => $externalId,
                'title' => trim($provider['Credentials']),
            ];

            // Save the import record to our database
            $importProviderEntity = $this->ImportProviders->newEntity($saveData);
            $this->ImportProviders->save($importProviderEntity);

            // Does this provider match an existing provider in our database?
            if (!empty($externalId) && !empty($existingProviders[$externalId])) {
                // Found a match
                $importProviderEntity->provider_id = $existingProviders[$externalId];
                $this->ImportProviders->save($importProviderEntity);
            } else {
                // TODO: Should I be saving a new provider to the provider table here, or does that happen in the import dashboard?
                $newCount++;
            }

            $importProviderId   = $importProviderEntity->id;
            $locationExternalId = (string)$provider['LocationID'];

            // Retrieve related Location
            if (empty($this->importLocations[$locationExternalId])) {
                $errorMessage = 'Warning: External location ID "' . $locationExternalId . '" does not exist within the most recent clinic list.  Please contact XML provider.';
                $io->error($errorMessage);
                $this->reportErrors[] = $errorMessage;
                continue;
            }
            $importLocationId   = $this->importLocations[$locationExternalId];

            // Save our association to the ImportLocationProvider table
            $locationProviderData = [
                'import_id'             => $this->importId,
                'import_provider_id'    => $importProviderId,
                'import_location_id'    => $importLocationId,
            ];
            $importLocationProviderEntity = $this->ImportLocationProviders->newEntity($locationProviderData);
            $this->ImportLocationProviders->save($importLocationProviderEntity);
        }
        // Set up our return data
        $caLogData = [
            'total_providers' => count($providers['ProviderItem']),
            'new_providers' => $newCount,
        ];
        return $caLogData;
    }

    /***************************************************
     * OTICON
     * *************************************************/

    /**
    * Run the oticon locations import
    */
    function oticon($bypass = false){
        $io = $this->io;
        $io->helper('BaseShell')->title("Import from Oticon");
        if (!Configure::read('isOticonImportEnabled')) {
            $io->error('Oticon imports are disabled on this server.');
            exit;
        }
        $oticonStart = microtime(true);
        // Retrieve the Oticon import file
        if ($this->bypass) {
            // Read most recent downloaded file
            $io->out('Bypassing file download. Reading local file: '.$this->oticonFilename);
            if (!file_exists($this->oticonFilename)) {
                $io->error('Unable to read file.');
                exit;
            }
        } else {
            // Download a new file from Oticon and save it in /tmp/
            $downloadStatus = $this->downloadOticonImportFile();
            if (!$downloadStatus) {
                $io->error('Failed to download Oticon file.');
                exit;
            }
        }
        $io->out("Location Import file: ".$this->oticonFilename);
        $retval = $this->parseOticonImport();

        $io->out('Import Complete');
        $io->out("{$retval['insert_count']} Records Inserted");
        $io->out("{$retval['update_count']} Records Updated");
        if (!empty($retval['unknown_tier_count_new'])) {
            $io->error("{$retval['unknown_tier_count_new']} New records have 'Unknown' oticon tier. Using T3.");
        }
        if (!empty($retval['unknown_tier_count_existing'])) {
            $io->error("{$retval['unknown_tier_count_existing']} Existing records have 'Unknown' oticon tier. Using last known tier.");
        }
        $io->out("{$retval['error_count']} Errors");
        if(!empty($retval['errors'])){
            $io->out('ERRORS:');
            $io->hr();
            print_r($retval['errors']);
            $io->hr();
        }
        $this->Locations->calculateListingTypes($io);
        $this->Locations->createClinicUsers($io);
        $this->Locations->addCallSourceNumbers($io);
        $this->Locations->CallSources->endInvalidCallSourceNumbers($io);
        $this->Locations->noShowLocations($io);
        $this->Locations->showClinicsWithActiveCS($io);
        $this->Locations->updateAllFilters($io);
        $this->Locations->updateAllCompleteness($io);

        // Create reports and send email
        $this->createOticonReports();

        $io->hr();
        $io->out('Oticon Import Complete');
    }

    /**
    * Download the Oticon import file from shared server
    */
    private function downloadOticonImportFile() {
        $io = $this->io;
        $server = Configure::read('oticonSharedServer');
        $io->out("Downloading Oticon import file. This will take a few minutes.");
        $io->helper('BaseShell')->sftpRetrieveFile(
            $this->oticonServer['url'],
            $this->oticonServer['username'],
            $this->oticonServer['password'],
            '/DF_SF_to_HH/Prod/HHCSVFeed.csv',
            $this->oticonFilename
        );
        return true;
    }

    /**
    * Run the oticon import. grab the tmp file and run with it.
    * @param xml path file_name to load
    * @return number of updated locations.
    */
    public function parseOticonImport() {
        $io = $this->io;
        $importData = csvToArrayWithHeaders($this->oticonFilename);
        //Exit here if we don't have any data to work with
        if (empty($importData)) {
            echo "No File to import.\n";
            return false;
        }
        //Setup return value array
        $retval = [
            'insert_count' => 0,
            'update_count' => 0,
            'unknown_tier_count_new' => 0,
            'unknown_tier_count_existing' => 0,
            'error_count' => 0,
            'errors' => []
        ];

        $io->out("Updating locations not in the import file (tier 0).");
        // Find all locations that are not in the oticon import and make them tier zero.
        $retval['update_count'] += $this->updateTierZeroLocations($importData);

        $io->out("\nUpdating/adding ".count($importData)." locations from the import file.");
        //Start the imports one at a time.
        foreach ($importData as $locationData) {
            $importLocationData = $this->parseOticonCsv($locationData);
            // There may be more than one location with the same Oticon id or SF id
            $locationIds = $this->findIdsByOticonId($importLocationData['id_oticon']);
            $locationIds = array_merge($locationIds, $this->findIdsBySfId($importLocationData['id_sf']));
            $locationIds = array_unique($locationIds);
            if (empty($locationIds)) {
                $locationIds[0] = null;
            }
            // Check for duplicates
            if (count($locationIds) > 1) {
                pr('Warning: Found multiple locations that match Oticon ID = '.$importLocationData['id_oticon'].' and/or SalesForce ID='.$importLocationData['id_sf']);
                pr($locationIds);
            }

            foreach ($locationIds as $locationId) {
                $data = $importLocationData;
                $data['country'] = countryAbbr($data['country']);
                $isNew = false;
                $needsCallSourceNumber = false;
                //Figure out Import Status and Geo Loc if new.
                if (!empty($locationId)) {
                    // Existing location
                    $location = $this->Locations->get($locationId);
                    $data['id'] = $locationId;
                    $data['is_active'] = $location->is_active;
                    $data['is_show'] = $location->is_show;
                    $data['listing_type'] = $location->listing_type;
                    $data['is_call_assist'] = $location->is_call_assist;
                    $data['yhn_tier'] = $location->yhn_tier;
                    $data['cqp_tier'] = $location->cqp_tier;
                    $data['is_retail'] = $location->is_retail;
                    $data['is_listing_type_frozen'] = $location->is_listing_type_frozen;
                    $data['is_grace_period'] = $location->is_grace_period;
                    $data['grace_period_end'] = $location->grace_period_end;
                    $data['is_email_ignore'] = $location->is_email_ignore;
                    $data['is_address_ignore'] = $location->is_address_ignore;
                    $data['is_title_ignore'] = $location->is_title_ignore;
                    $data['is_phone_ignore'] = $location->is_phone_ignore;
                    $lastOticonTier = $location->oticon_tier;
                    if (!in_array($data['oticon_tier'], [1, 2, 3])) {
                        // If tier value is Unknown, keep the last known value and display an error. We should let Vikas know.
                        pr('Warning: Tier = '.$data['oticon_tier'].' for location '.$locationId.', id_sf='.$data['id_sf']);
                        $data['oticon_tier'] = $lastOticonTier;
                        $retval['unknown_tier_count_existing']++;
                    }
                    if ($data['oticon_tier'] != $lastOticonTier) {
                        $data['last_import_status'] = ImportStatus::IMPORT_STATUS_TIER_CHANGED;
                        if (($data['oticon_tier'] == 3) && (in_array($lastOticonTier, [1,2]))) {
                            // Location dropped from Oticon T1/T2 to T3 - Set 90 day grace period
                            $data['is_grace_period'] = true;
                            $data['grace_period_end'] = date('Y-m-d', strtotime('+ 90 days'));
                            $noteBody = 'Start of 90 day grace period.';
                            $this->LocationNotes->add($locationId, $noteBody);
                        } elseif (in_array($data['oticon_tier'], [1,2])) {
                            if ($data['is_grace_period']) {
                                $data['is_grace_period'] = false;
                                $data['grace_period_end'] = null;
                                $noteBody = 'End of grace period due to tier change.';
                                $this->LocationNotes->add($locationId, $noteBody);
                            }
                        }
                    } else {
                        $data['last_import_status'] = ImportStatus::IMPORT_STATUS_NO_CHANGE;
                    }
                    $retval['update_count']++;
                } else {
                    // New location
                    $isNew = true;
                    unset($data['id']);
                    $data['is_call_assist'] = false;
                    $data['is_active'] = true;
                    $data['is_show'] = false;
                    $data['listing_type'] = Location::LISTING_TYPE_NONE;
                    $data['yhn_tier'] = 0;
                    $data['cqp_tier'] = 0;
                    $data['is_retail'] = false;
                    $data['is_grace_period'] = false;
                    $data['grace_period_end'] = null;
                    $data['is_listing_type_frozen'] = false;
                    $data['last_import_status'] = ImportStatus::IMPORT_STATUS_NEW_LOCATION;
                    $data['priority'] = 'New';
                    $data['payment'] = '{"2":"0","4":"0","8":"0","16":"0","32":"0","64":"1","128":"1","256":"0"}';
                    $data['is_email_ignore'] = false;
                    $data['is_address_ignore'] = false;
                    $data['is_title_ignore'] = false;
                    $data['is_phone_ignore'] = false;

                    if (!in_array($data['oticon_tier'], [1, 2, 3])) {
                        // If tier value is unknown, default to tier 3 and display a warning. Let Vikas know.
                        $io->error('Warning: Tier = '.$data['oticon_tier'].' for id_sf '.$data['id_sf'].'. Defaulting to tier 3 (no grace).');
                        $data['oticon_tier'] = 3;
                        $retval['unknown_tier_count_new']++;
                    }
                    $retval['insert_count']++;
                }
                // Calculate listing_type and is_call_assist
                $data['listing_type'] = $this->Locations->calculateListingType($data);
                $data['is_call_assist'] = $this->Locations->calculateIsCallAssist($data);
                if ($data['is_active'] && ($data['listing_type'] != Location::LISTING_TYPE_NONE)) {
                    // Make sure active Basic/Enhanced/Premier clinics have a CallSource number assigned
                    $csNumberCount = 0;
                    if (!empty($locationId)) {
                        $csNumberCount = $this->CallSources->find('all', [
                            'conditions' => ['location_id' => $locationId]
                        ])->count();
                    }
                    if ($csNumberCount > 1) {
                        echo "\nWARNING: Location ".$locationId." has multiple CS numbers assigned.\n";
                    }
                    $needsCallSourceNumber = ($csNumberCount == 0) ? true : false;
                    if ($needsCallSourceNumber) {
                        // Do not show the location until the new number has been assigned.
                        $data['is_show'] = false;
                    }
                }
                $importStatusData = [
                    'oticon_tier' => $data['oticon_tier'],
                    'listing_type' => $data['listing_type'],
                    'is_active' => $data['is_active'],
                    'is_show' => $data['is_show'],
                    'is_grace_period' => $data['is_grace_period'],
                    'status' => $data['last_import_status'],
                ];

                //Decide the status of the address and title changes
                $data['address_status'] = $this->Locations->calcAddressStatus($data);
                $data['title_status'] = $this->Locations->calcTitleStatus($data);
                $data['phone_status'] = $this->Locations->calcPhoneStatus($data);
                $data['email_status'] = $this->Locations->calcEmailStatus($data);

                foreach (['address','phone','title','email'] as $field) {
                    if ($data['is_' . $field . '_ignore']) {
                        // If import data matches HH data, clear the ignore field
                        if ($data[$field . '_status'] == Location::CHANGE_STATUS_NO_DIFFERENCE) {
                            $data['is_' . $field . '_ignore'] = false;
                        }
                        // If oticon data has changed since last import, clear the ignore field
                        $lastXmlParsed = $this->Locations->parseOticonXml($location->last_xml);
                        if ($field == 'address') {
                            $newAddress = $lastAddress = '';
                            foreach (['address','address_2','city','zip','state'] as $addressField) {
                                $newAddress .= $data[$addressField].' ';
                                $lastAddress .= ($lastXmlParsed->$addressField ?? '').' ';
                            }
                            $newAddress = trim(preg_replace('/\s+/', ' ', $newAddress));
                            $lastAddress = trim(preg_replace('/\s+/', ' ', $lastAddress));
                            if ($newAddress != $lastAddress) {
                                $data['is_' . $field . '_ignore'] = false;
                            }
                        } else {
                            if ($lastXmlParsed->$field != $data[$field]) {
                                $data['is_' . $field . '_ignore'] = false;
                            }
                        }
                    }
                }

                //Save the location data.
                // If this is an existing location, unset some fields.
                // For a new import, save all fields.
                if (!$isNew) {
                    // The following fields will be updated with what we found in the import (or calculate), nothing else!
                    // We don't want to automatically overwrite title, address, phone, email, etc...
                    $fields = [
                        // imported
                        'id_oticon', 'id_parent', 'id_sf', 'oticon_tier', 'location_segment', 'entity_segment', 'last_import_status',
                        // calculated
                        'id', 'listing_type', 'is_listing_type_frozen', 'last_xml', 'title_status', 'address_status', 'phone_status', 'email_status', 'is_phone_ignore', 'is_address_ignore', 'is_title_ignore', 'is_email_ignore', 'is_show', 'is_grace_period', 'grace_period_end', 'is_call_assist'
                    ];
                    $data = array_intersect_key($data, array_flip($fields));
                    $locationEntity = $this->Locations->get($data['id']);
                    $this->Locations->patchEntity($locationEntity, $data);
                } else {
                    $locationEntity = $this->Locations->newEntity($data);
                }
                try {
                    if ($this->Locations->save($locationEntity)) {
                        echo '.'; //success output
                        if ($needsCallSourceNumber) {
                            // This clinic needs a new or updated CallSource tracking number.
                            $this->CallSources->saveCallSource($locationEntity->id);
                        }
                        if ($isNew) {
                            // Geocode this Location
                            $this->Locations->geoLocById($locationEntity->id);
                        }
                        $importStatusData['location_id'] = $locationEntity->id;
                        $importStatusEntity = $this->ImportStatus->newEntity($importStatusData);
                        $this->ImportStatus->save($importStatusEntity);
                    } else { //Error saving the location, figure out why.
                        // Failed to save the location
                        $io->error('Failed to save Location entity');
                        $errors = print_r($locationEntity->getErrors(), true);
                        $io->out($errors);
                        pr($locationEntity);
                        $retval['error_count']++;
                        $retval['errors'][$data['id_oticon']] = $errors;
                        echo 'f'; //failure output
                    }
                } catch (Exception $e) {
                    $io->error('Unable to save location');
                    pr($locationEntity);
                    pr($e->getMessage());
                    $this->abort();
                }
            }
        }
        echo "\nImport complete.\n";
        return $retval;
    }

    /**
    * Find all locations that do not exist in the import file. Update those locations to Tier 0.
    * @return boolean success.
    */
    private function updateTierZeroLocations($importData) {
        if (!empty($importData)) {
            // Find the list of all oticon ids in the import
            $oticonIds = [];
            foreach ($importData as $location) {
                if (isset($location['Id'])) {
                    $oticonIds[] = $location['Id'];
                }
            }
            // Find all locations not in the import
            $locations = $this->Locations->find('all', [
                'conditions' => [
                    'id_oticon NOT IN' => $oticonIds,
                ],
            ])->all();
            foreach ($locations as $count => $location) {
                $import_status = ($location->oticon_tier == 0) ? ImportStatus::IMPORT_STATUS_NO_CHANGE : ImportStatus::IMPORT_STATUS_TIER_CHANGED;
                $locationId = $location->id;

                // Set these fields before we calculate the new listing type
                $location->oticon_tier = 0;
                $location->is_grace_period = false;
                $location->grace_period_end = null;
                $location->last_import_status = $import_status;
                if ($this->Locations->save($location)) {
                    echo '.';
                    $newListingType = $this->Locations->calculateListingType($location);
                    $this->Locations->calculateIsCallAssist($location);
                    $isShow = ($newListingType == Location::LISTING_TYPE_NONE) ? false : $location->is_show;
                    $importStatusData = [
                        'location_id' => $locationId,
                        'status' => $import_status,
                        'oticon_tier' => 0,
                        'listing_type' => $newListingType,
                        'is_active' => $location->is_active,
                        'is_show' => $isShow,
                        'is_grace_period' => false,
                    ];
                    $importStatusEntity = $this->ImportStatus->newEntity($importStatusData);
                    $this->ImportStatus->save($importStatusEntity);
                } else {
                    echo 'f';
                    pr('Error: Failed to save location '.$location->id);
                }
            }
            return count($locations);
        }
        return false;
    }

    /**
    * Parses an array object of a single Location given to us by Oticon
    * @param array
    * @return array parsed of Location fields to save. false if unable to parse.
    */
    public function parseOticonCsv($data) {
        if (empty($data)) {
            return false;
        }
        $saveData = [];
        $saveData['last_xml'] = json_encode($data);
        foreach ($data as $key => $value) {
            //Organize Location data
            $saveData[strtolower($key)] = $value;
        }
        // Calculate oticon tier based on segment
        $saveData['location_segment'] = isset($saveData['locationsegment']) ? $saveData['locationsegment'] : null;
        if (in_array($saveData['location_segment'], ['A1', 'B1', 'C1', 'D1', 'A2'])) {
            $oticonTier = 1;
        } elseif (in_array($saveData['location_segment'], ['B2', 'C2', 'D2', 'A3', 'B3', 'C3', 'D3'])) {
            $oticonTier = 2;
        } elseif (in_array($saveData['location_segment'], ['A4', 'B4', 'C4', 'D4'])) {
            $oticonTier = 3;
        } else {
            $oticonTier = 0;
            pr('Warning. Unknown segment ('.$saveData['location_segment'].') for location '.$saveData['id']);
        }
        $saveData['oticon_tier'] = $oticonTier;

        // Clean phone number
        $saveData['phone'] = trim(str_replace(array('(', ')','-', ' '), '', $saveData['phone']));

        // The import file has whole address in a single field. We need to split out address_2 data.
        $saveData['address_2'] = '';
        if (!empty($saveData['address'])) {
            $pos = stripos($saveData['address'], ' Building');
            if (empty($pos)) {
                $pos = stripos($saveData['address'], ' Bldg');
            }
            if (empty($pos)) {
                $pos = stripos($saveData['address'], ' Suite');
            }
            if (empty($pos)) {
                $pos = stripos($saveData['address'], ' Ste');
            }
            if (empty($pos)) {
                $pos = stripos($saveData['address'], ' Unit');
            }
            if (empty($pos)) {
                $pos = stripos($saveData['address'], ' #');
            }
            if (!empty($pos)) {
                $saveData['address_2'] = trim(substr($saveData['address'], $pos));
                $saveData['address'] = substr($saveData['address'], 0, $pos);
            }
        }

        $saveData['id_oticon'] = $saveData['id'];
        $saveData['id_sf'] = $saveData['sfid'];
        $saveData['id_parent'] = isset($saveData['parentaccountid']) ? $saveData['parentaccountid'] : null;

        $saveData['city'] = cleanCityName($saveData['city']);
        $saveData['zip'] = (strlen($saveData['zip']) == 10 && strpos($saveData['zip'],'-') > 0 ? substr($saveData['zip'],0,5) : $saveData['zip']);//99576-0130
        unset($saveData['id'],
            $saveData['sfid'],
            $saveData['created'],
            $saveData['modified'],
            $saveData['parentaccountid'],
            $saveData['locationsegment'],
            $saveData['tier']);

        return $saveData;
    }

    /**
    * Find all location ids that match the Oticon id.
    */
    public function findIdsByOticonId($oticonId = '') {
        if (trim($oticonId)) {
            $locationList = $this->Locations->find('list', [
                'keyField' => 'id',
                'valueField' => 'id',
                'conditions' => [
                    'id_oticon' => $oticonId,
                ],
            ])->toArray();
            return $locationList;
        }
        return false;
    }

    /**
    * Find all location ids that match the Salesforce Id.
    */
    public function findIdsBySfId($sf_id = '') {
        if (trim($sf_id)) {
            $locationList = $this->Locations->find('list', [
                'keyField' => 'id',
                'valueField' => 'id',
                'conditions' => [
                    'id_sf' => $sf_id,
                ],
            ])->toArray();
            return $locationList;
        }
        return false;
    }

    /*
     *  Generate the Oticon Import Reports and send email
     */
    function oticonNumbersReport($filename) {
        if (empty($filename)) {
            $this->io->error('Error: No filename given in oticonNumbersReport().');
            return false;
        }
        $dirname = dirname($filename);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        $csvFile = fopen($filename, 'w');
        fputcsv($csvFile, ["Customer Name","Customer Code","Phone Number","Target Number"]);
        $month = date("Y-m-01");
        $numbers = $this->CallSources->find('all', [
            'conditions' => [
                'created >=' => $month
            ]
        ])->all();
        foreach ($numbers as $number) {
            $customerCode = $this->CallSources->getCustomerCode($number->location_id);
            fputcsv($csvFile, [$number->customer_name, $customerCode, $number->phone_number, $number->target_number]);
        }
        fclose($csvFile);
    }

    function oticonCountReport($filename) {
        if (empty($filename)) {
            $this->io->error('Error: No filename given in oticonNumbersReport().');
            return false;
        }
        $dirname = dirname($filename);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        $locationCount = $this->Locations->find('all', [
            'conditions' => ['is_active' => 1]
        ])->count();
        $providerCount = $this->Providers->find('all', [
            'conditions' => ['is_active' => 1]
        ])->count();

        $fileData = "-- Oticon Count Report : ".date('Y-m-d')." --\n\n";
        $fileData .= "Active Locations: " . $locationCount."\n";
        $fileData .= "Active Providers: " . $providerCount."\n\n";

        foreach (Location::$listingTypes as $listingType => $listingTypeDescription) {
            // Don't show listing_type=None stats.
            if ($listingType == Location::LISTING_TYPE_NONE) {
                continue;
            }
            $listingTypeCount = $this->Locations->find('all', [
                'conditions' => ['listing_type' => $listingType],
            ])->count();
            $listingTypePercentage = number_format(($listingTypeCount / $locationCount) * 100, 2) . '%';
            $fileData .= "Listing Type ".$listingType.": ".$listingTypeCount." (".$listingTypePercentage.")\n";
            $fileData .= $this->listingTypeStats($listingType)."\n\n";
        }

        $fileData .= $this->overallStats();
        $fileData .= "\n";
        $fileData .= $this->reviewStats();
        $fileData .= "\n";
        $fileData .= $this->callsourceStats();
        file_put_contents($filename, $fileData);
    }

    function listingTypeStats($listingType) {
        $result = '';
        $stats = [
            'clinics' => [],
            'isOticon' => ['oticon_tier >' => 0],
            'isYHN' => ['yhn_tier >' => 0],
            'isCQP' => ['cqp_tier >' => 0],
            'Complete' => ['completeness' => Location::COMPLETENESS_COMPLETE],
            'BasicInfo' => ['completeness' => Location::COMPLETENESS_BASIC_INFO],
            'ProfilePic' => ['completeness' => Location::COMPLETENESS_PROFILE_PIC],
            'Incomplete' => ['completeness' => Location::COMPLETENESS_INCOMPLETE],
            'url' => ['url !=' => ''],
            'reviews_approved' => ['reviews_approved >' => 0],
            '3_reviews' => ['reviews_approved >' => 2]
        ];
        foreach ($stats as $key => $statConditions) {
            $conditions = array_merge(['listing_type' => $listingType], $statConditions);
            $statValue = $this->Locations->find('all', [
                'conditions' => $conditions
            ])->count();
            if ($key == 'clinics') {
                $clinics = $statValue;
                continue;
            }
            if (empty($statValue)) {
                $statValue = 0;
            }
            $statPercentage = number_format($statValue / $clinics * 100, 2) . '%';
            $key = ucfirst(str_replace('_', ' ', $key));
            $result .= "  " . $key . ": " . $statValue . " (" . $statPercentage . ")\n";
        }
        return $result;
    }

    function overallStats() {
        $result = "Overall Stats\n";
        $clinics = $this->Locations->find('all')->count();
        $result .= "  Total clinics: ".$clinics."\n";
        $listingTypes = [Location::LISTING_TYPE_PREMIER, Location::LISTING_TYPE_ENHANCED, Location::LISTING_TYPE_BASIC];
        foreach ($listingTypes as $listingType) {
            $stats = [
                $listingType.'/Active/Show' => [
                    'listing_type' => $listingType,
                    'is_active' => 1,
                    'is_show' => 1,
                ],
                $listingType.'/Active/No Show' => [
                    'listing_type' => $listingType,
                    'is_active' => 1,
                    'is_show' => 0,
                ],
                $listingType.'/Inactive/Show' => [
                    'listing_type' => $listingType,
                    'is_active' => 0,
                    'is_show' => 1,
                ],
                $listingType.'/Inactive/No Show' => [
                    'listing_type' => $listingType,
                    'is_active' => 0,
                    'is_show' => 0,
                ]
            ];
            foreach ($stats as $key => $conditions) {
                $statValue = $this->Locations->find('all', [
                    'conditions' => $conditions
                ])->count();
                if (empty($statValue)) {
                    $statValue = 0;
                }
                $statPercentage = number_format($statValue / $clinics * 100, 2) . '%';
                $key = ucfirst(str_replace('_', ' ', $key));
                $result .= "  " . $key . ": " . $statValue . " (" . $statPercentage . ")\n";
            }
        }
        return $result;
    }

    function reviewStats() {
        $totalReviews = $this->Locations->Reviews->find('all')->count();
        $return = "Total Reviews: ".$totalReviews."\n";
        $origins = ReviewOrigin::getOriginLabelArray();
        foreach ($origins as $origin => $originLabel) {
            $originCount = $this->Locations->Reviews->find('all', [
                'conditions' => ['origin' => $origin]
            ])->count();
            $statPercentage = number_format($originCount / $totalReviews * 100, 2) . '%';
            $return .= "  ".$originLabel .": ".$originCount." (".$statPercentage.")\n";
        }
        return $return;
    }

    function callsourceStats() {
        $csActive = $this->CallSources->find('all', ['conditions' => ['is_active' => true]])->count();
        $return = 'Active CallSource Numbers: ' . $csActive . "\n\n";
        return $return;
    }

    /*
     *  Generate the Oticon Import Reports and send email
     */
    function createOticonReports() {
        $io = $this->io;
        $io->helper('BaseShell')->title('Creating Oticon import report');
        $date = date("Y-m-d");

        $io->out("Running Numbers.");
        $csNumbersFilename = "tmp/oticon_imports/callsource_numbers_$date.csv";
        $this->oticonNumbersReport($csNumbersFilename);

        $io->out("Running Count.");
        $oticonCountFilename = "tmp/oticon_imports/oticon_count_$date.txt";
        $this->oticonCountReport($oticonCountFilename);

        $body = 'Oticon Import Data Attached<br><br>';
        $count = $this->ImportStatus->countTierChanges('today');
        $body .= "$count locations changed tier.";

        $email = [];
        $email['body'] = $body;
        if (Configure::read('env') == 'prod') {
            $email['to'] = Configure::read('import-email');
        } else {
            $email['to'] = Configure::read('developerEmails');
        }
        $email['subject'] = 'Oticon Import - '.date('m-d-Y');
        $email['attachments'] = [
            $csNumbersFilename,
            $oticonCountFilename
        ];
        // Send email
        $this->getMailer('Admin')->send('default', [$email]);
        $io->out('Import report email sent to '.implode(', ', $email['to']));
    }
}
