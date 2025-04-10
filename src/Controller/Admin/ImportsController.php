<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Location;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Utility\Hash;

/**
 * Imports Controller
 *
 * @property \App\Model\Table\ImportsTable $Imports
 * @method \App\Model\Entity\Import[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportsController extends BaseAdminController
{
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->paginate = [
            'order' => ['Imports.id' => 'DESC']
        ];
        $this->Locations = TableRegistry::get('Locations');
        $this->ImportDiffs = TableRegistry::get('ImportDiffs');
        $this->ImportLocations = TableRegistry::get('ImportLocations');
        $this->Providers = TableRegistry::get('Providers');
        $this->ImportProviders = TableRegistry::get('ImportProviders');
        $this->LocationsProviders = TableRegistry::get('LocationsProviders');
        $this->Users = TableRegistry::get('Users');
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $externalIdLabel = Configure::read('isYhnImportEnabled') ? 'YHN ID' : 'External ID';
        $this->set('externalIdLabel', $externalIdLabel);
    }

    private function getImportIndexReferer() {
        $referer = $this->request->getSession()->read('importIndexReferer');
        if (empty($referer)) {
            $referer = '/admin/import-locations';
        }
        return $referer;
    }

    private function flashValidationErrors($errors) {
        $errorList = [];
        foreach ($errors as $model => $modelErrors) {
            foreach ($modelErrors as $modelError) {
                if (is_array($modelError)) {
                    foreach ($modelError as $errorMessage) {
                        $errorList[] = '<li>' . $model.' - '.$errorMessage . '</li>';
                    }
                } else {
                    $errorList[] = '<li>' . $model.' - '.$modelError . '</li>';
                }
            }
        }
        $errorMessages = '<ul>' . implode(' ', $errorList) . '</ul>';
        $this->Flash->error('Errors: <br>' . $errorMessages, ['escape' => false]);
    }

    /**
     * Index method - Import Stats
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $importsQuery = $this->Imports->find('all', [
            'contain' => []
        ]);
        $imports = $this->paginate($importsQuery);
        $this->set('title', 'Imports');
        $this->set('imports', $imports);
        $this->set('fields', $this->Imports->getSchema()->typeMap());
        $this->set('count', $importsQuery->count());
    }

    /**
     * View method
     *
     * @param string|null $id Import id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $import = $this->Imports->get($id, [
            'contain' => ['ImportDiffs', 'ImportLocationProviders', 'ImportLocations', 'ImportProviders'],
        ]);

        $this->set(compact('import'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $import = $this->Imports->newEmptyEntity();
        if ($this->request->is('post')) {
            $import = $this->Imports->patchEntity($import, $this->request->getData());
            if ($this->Imports->save($import)) {
                $this->Flash->success(__('The import has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import could not be saved. Please, try again.'));
        }
        $this->set('title', 'Add Import');
        $this->set(compact('import'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Import id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $import = $this->Imports->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $import = $this->Imports->patchEntity($import, $this->request->getData());
            if ($this->Imports->save($import)) {
                $this->Flash->success(__('The import has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import could not be saved. Please, try again.'));
        }
        $this->set('title', 'Edit Import');
        $this->set(compact('import'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Import id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $import = $this->Imports->get($id);
        if ($this->Imports->delete($import)) {
            $this->Flash->success(__('The import has been deleted.'));
        } else {
            $this->Flash->error(__('The import could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function locationReview($locationId, $importLocationId) {
        $location = $this->Locations->get($locationId);
        if (empty($location)) {
            $this->Flash->error('Location not found.');
            return $this->redirect('/admin/imports');
        }
        $importIndexReferer = $this->getImportIndexReferer();

        // Retrieve all diffs related to this view
        $importDiffs = $this->ImportDiffs->find('all', [
            'conditions' => [
                'model'     => 'Location',
                'id_model'  => $locationId,
                'review_needed' => 1,
            ],
            'order' => [
                'created DESC'
            ]
        ])->toArray();
        $diffs = [];
        foreach ($importDiffs as $diff) {
            $field = $diff->field;
            $diffs[$field][] = $diff->toArray();
        }

        // Retrieve our related location information from the last import
        $importLocation = $this->ImportLocations->get($importLocationId, [
            'contain' => ['Imports']
        ]);
        if (empty($importLocation)) {
            $this->Flash->error('Import location not found.');
            return $this->redirect('/admin/imports');
        }

        // Retrieve the provider information from this Location
        $providers = $this->Providers->findByLocationId($locationId);

        // Retrieve the YHN Provider information related to this specific import
        $importProviders = $this->ImportProviders->getByImportLocationId($importLocationId);
        $importProviderIds = [];
        $providerDiffs = [];
        $orderedImportProviders = [];

        foreach ($importProviders as $importProvider) {
            $importProviderId = $importProvider->id_external;
            if (!empty($importProvider->provider_id)) {
                $providerId = $importProvider->provider_id;
                $importProviderDiffs = $this->ImportDiffs->find('all', [
                    'conditions' => [
                        'model'     => 'Provider',
                        'id_model'  => $providerId,
                        'review_needed' => 1,
                    ],
                    'order' => [
                        'created DESC'
                    ]
                ])->toArray();
                foreach ($importProviderDiffs as $diff) {
                    $field = $diff['field'];
                    $providerDiffs[$providerId][$field][] = $diff;
                }
            }
            $orderedImportProviders[$importProviderId] = $importProvider;
            $importProviderIds[] = $importProviderId;
        }

        // Save data if there's data to save!
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Retrieve data from POST
            $locationData = $this->request->getData();
            $providerData = $locationData['providers'] ?? [];

            // Make sure we are saving a valid state abbr
            $locationData['state'] = $this->Locations->stateAbbr($locationData['state']);

            // Mark the location as no longer needing review
            $locationData['review_needed'] = 0;

            // Create a note for the import changes
            $noteBody = '<u>'.strtoupper($importLocation->import->type).' Import</u><br>';

            // Mark the diffs as no longer needing review
            $noteFields = [];
            foreach ($importDiffs as $importDiff) {
                $importDiff->review_needed = 0;
                $this->ImportDiffs->save($importDiff);
                $field = $importDiff->field;
                $addNote = true;
                if (trim($locationData[$field]) == trim($importDiff->value)) {
                    if (trim($locationData[$field]) == trim($location->{$field})) {
                        // Don't add a note if we already had the correct value
                        $addNote = false;
                    }
                    if ($addNote) {
                        $noteBody .= $field.': Accepted import change<br>';
                    }
                } else {
                    $noteBody .= $field.': Ignored import change<br>';
                }
                if ($addNote) {
                    $noteBody .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$locationData[$field].' &larr; '.$importDiff->value.'<br>';
                }
                $noteFields[] = $field;
            }
            foreach ($locationData as $locationField => $value) {
                if (!in_array($locationField, $noteFields)) {
                    if (!is_array($value)) {
                        if ($value != $location->{$locationField}) {
                            // We accepted an import change that was previously ignored
                            $noteBody .= $locationField.': Accepted import change<br>';
                            $noteBody .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$location->{$locationField}.' &larr; '.$value.'<br>';
                        }
                    }
                }
            }
            $providerNoteFields = [];
            foreach ($providerDiffs as $providerDiff) {
                foreach ($providerDiff as $field => $fieldDiff) {
                    foreach($fieldDiff as $diff) {
                        $diff->review_needed = 0;
                        $this->ImportDiffs->save($diff);
                        foreach ($providerData as $provider) {
                            if ((isset($provider['id']) && ($provider['id'] == $diff->id_model)) ||
                                (empty($provider['id']) && empty($diff->id_model))) {
                                $addNote = true;
                                if (trim($provider[$field]) == trim($diff->value)) {
                                    if (!empty($provider['id'])) {
                                        $providerEntity = $this->Providers->get($provider['id']);
                                        $oldValue = $providerEntity->{$field};
                                        if (trim($provider[$field]) == trim($oldValue)) {
                                            // Don't add a note if we already had the correct value
                                            $addNote = false;
                                        }
                                    }
                                    if ($addNote) {
                                        $noteBody .= 'Provider '.$field.': Accepted import change<br>';
                                    }
                                } else {
                                    $noteBody .= 'Provider '.$field.': Ignored import change<br>';
                                }
                                if ($addNote) {
                                    $noteBody .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$provider[$field].' &larr; '.$diff->value.'<br>';
                                }
                                $providerNoteFields[] = $field;
                            }
                        }
                    }
                }
            }
            foreach ($providerData as $provider) {
                if (!empty($provider['id'])) {
                    $providerEntity = $this->Providers->get($provider['id']);
                    foreach ($provider as $providerField => $value) {
                        if (!in_array($providerField, $providerNoteFields)) {
                            $oldValue = $providerEntity->{$providerField};
                            if ($value != $oldValue) {
                                // We accepted an import change that was previously ignored
                                $noteBody .= 'Provider '.$providerField.': Accepted import change<br>';
                                $noteBody .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$oldValue.' &larr; '.$value.'<br>';
                            }
                        }
                    }
                }
            }

            // Save the POST data to the Location
            $location = $this->Locations->patchEntity(
                $location,
                $locationData,
                ['associated' => []]
            );
            if (!$this->Locations->save($location)) {
                $errors = json_encode(Hash::flatten($location->getErrors()));
                $this->Flash->error('Failed to save location '.$locationId.'<br>'.$errors, ['escape' => false]);
                return $this->redirect('/admin/imports');
            }

            // Get the list of YHN Providers to update
            foreach ($providerData as $provider) {
                if (empty($provider['id']) && !empty($provider['first_name'])) {
                    // Add a note for new providers
                    $noteBody .= 'Provider added<br>';
                    foreach (['first_name', 'last_name', 'email'] as $field) {
                        $noteBody .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$field.': '.$provider[$field].'<br>';
                    }
                    $providerEntity = $this->Providers->newEntity($provider);
                } else {
                    $providerEntity = $this->Providers->get($provider['id']);
                }
                $yhnProviderId = $provider['id_yhn_provider'];
                $providerEntity->is_active = true;

                // Save this provider. It may be new or updated.
                $this->Providers->save($providerEntity);
                $providerId = $providerEntity->id;

                // Link this location to this provider (if they aren't already)
                $locationsProvidersCount = $this->LocationsProviders->find('all', [
                    'conditions' => [
                        'provider_id' => $providerId,
                        'location_id' => $locationId
                    ],
                ])->count();
                if (empty($locationsProvidersCount)) {
                    $locationsProvidersData = [
                        'provider_id' => $providerId,
                        'location_id' => $locationId,
                    ];
                    $locationsProvidersEntity = $this->LocationsProviders->newEntity($locationsProvidersData);
                    $this->LocationsProviders->save($locationsProvidersEntity);
                }

                // Save our Provider ID to the ImportProvider table
                if (!empty($orderedImportProviders[$yhnProviderId]) && ($orderedImportProviders[$yhnProviderId]['provider_id'] != $providerId)) {
                    $importProviderEntity = $this->ImportProviders->get($orderedImportProviders[$yhnProviderId]['id']);
                    $importProviderEntity->provider_id = $providerId;
                    $this->ImportProviders->save($importProviderEntity);
                }
            }

            $this->Locations->updateFilters($locationId);
            $this->Locations->completeness($locationId);
            $this->Locations->LocationNotes->add($locationId, $noteBody);

            // Successfully reviewed! Return us to the referring index page.
            $this->Flash->success('Location has been reviewed!');
            return $this->redirect($importIndexReferer);
        }

        // Send our data to the view.
        $this->set('location', $location);
        $this->set('importLocation', $importLocation);
        $this->set('providers', $providers);
        $this->set('importProviders', $orderedImportProviders);
        $this->set('importProviderIds', $importProviderIds);
        $this->set('diffs', $diffs);
        $this->set('providerDiffs', $providerDiffs);
        $this->set('fields', $this->ImportLocations->fields);
        $this->set('providerFields', $this->ImportProviders->fields);
        $this->set('importIndexReferer', $importIndexReferer);
    }

    public function locationAdd($importLocationId) {
        $importIndexReferer = $this->getImportIndexReferer();
        $importLocation = $this->ImportLocations->findById($importLocationId)->contain('Imports')->first();
        if (empty($importLocation)) {
            $this->Flash->error('Import location could not be found.');
            return $this->redirect('/admin/imports');
        }

        $this->set('importLocation', $importLocation);
        $this->set('importIndexReferer', $importIndexReferer);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $officeData = $this->request->getData();

            // New locations are always saved with active and
            // Basic for YHN, Enhanced for HD Canada
            $listingType = Configure::read('isTieringEnabled') ? Location::LISTING_TYPE_BASIC : Location::LISTING_TYPE_ENHANCED;
            $locationData = [
                'id_oticon' => $officeData['id_oticon'],
                'address' => $officeData['address'],
                'address_2' => $officeData['address_2'],
                'city' => $officeData['city'],
                'state' => $officeData['state'],
                'zip' => $officeData['zip'],
                'country' => Configure::read('country'),
                'review_needed' => 0,
                'title' => $officeData['title'],
                'phone' => $officeData['phone'],
                'email' => $officeData['email'],
                'url' => $officeData['url'],
                'is_retail' => $officeData['is_retail'],
                'id_yhn_location' => $officeData['id_external'],
                'listing_type' => $listingType,
                'is_active' => true,
                'is_show' => false,
                'payment' => null,
                'filter_insurance' => true,
                'is_call_assist' => false,
            ];
            if ($importLocation->import->type == "yhn") {
                $locationData['is_yhn'] = true;
                $locationData['yhn_tier'] = 2;
            } else if ($importLocation->import->type == "cqp") {
                $locationData['is_cqp'] = true;
                $locationData['cqp_tier'] = 2;
                $locationData['id_cqp_practice'] = $officeData['id_cqp_practice'];
                $locationData['id_cqp_office'] = $officeData['id_cqp_office'];
            } else { // Canada
                $locationData['yhn_tier'] = 2;
            }

            $location = $this->Locations->newEntity($locationData);
            $errors = $location->getErrors();
            if (empty($errors)) {
                $this->Locations->save($location);
            } else { // validation errors
                $this->flashValidationErrors($errors);
                return $this->redirect('/admin/imports/location_add/' . $importLocationId);
            }

            $locationId = $location->id;

            // Add a location user for this Location
            $this->Users->createClinicUserFromLocationId($locationId);

            // Geocode this Location
            $this->Locations->geoLocById($locationId);

            // Update Review Status
            $this->Locations->updateReviewStatus($locationId);
            $this->Locations->completeness($locationId);

            $importLocationEntity = $this->ImportLocations->get($importLocationId);
            $importLocationEntity->location_id = $locationId;
            $importLocationEntity->match_type = 4;
            $this->ImportLocations->save($importLocationEntity);

            $importProviders = $this->ImportProviders->getByImportLocationId($importLocationId); 

            // Automatically add each YHN Provider from here to 
            foreach ($importProviders as $importProviderData) {
                $importProvider = $importProviderData['ImportProvider'];

                // Put together the list of fields for saving the Provider
                $providerData = [
                    'first_name' => $importProvider['first_name'],
                    'last_name' => $importProvider['last_name'],
                    'email' => $importProvider['email'],
                    'is_active' => 1,
                    'aud_or_his' => $importProvider['aud_or_his'],
                    'credentials' => '',
                    'id_yhn_provider' => $importProvider['id_external'],
                ];

                // Save this provider as a new provider
                $provider = $this->Providers->newEntity($providerData);
                $this->Providers->save($provider);
                $providerId = $provider->id;

                // Add the entry to location_providers, to link this provider to this location.
                $locationProviderData = [
                    'provider_id' => $providerId,
                    'location_id' => $locationId,
                ];
                $locationProvider = $this->LocationsProviders->newEntity($locationsProvidersData);
                $this->LocationProviders->save($locationProvider);
            }

            $this->Locations->setEmailsFromProviders($locationId);

            if (Configure::read('isCallSourceGenerationEnabled')) {
                // Add this number to the input dashboard.
                $this->Locations->CallSources->saveCallSource($locationId);
            }

            // Successfully added! Return us to the referring index page.
            $this->Flash->success('Location has been added!');
            return $this->redirect($importIndexReferer);
        }
    }

    public function locationLink($importLocationId) {
        $importIndexReferer = $this->getImportIndexReferer();
        $importLocation = $this->ImportLocations->get($importLocationId, [
            'contain' => ['Imports']
        ]);
        $locationId = $importLocation->location_id;

        if (!empty($locationId)) {
            $location = $this->Locations->get($locationId);
            if ($importLocation->import->type == 'cqp') {
                $location->id_cqp_practice = $importLocation->id_cqp_practice;
                $location->id_cqp_office = $importLocation->id_cqp_office;
                $location->is_cqp = true;
                $location->cqp_tier = 2;
                $location->review_needed = true;
                $this->Locations->save($location);
            } else {
                $location->id_yhn_location = $importLocation->id_external;
                $location->is_yhn = true;
                $location->yhn_tier = 2;
                $location->review_needed = true;
                $this->Locations->save($location);
            }

            // Save the Location ID & Match Type (just for record keeping in db)
            $importLocation->location_id = $locationId;
            $importLocation->match_type = 5;
            $this->ImportLocations->save($importLocation);

            // Recalculate listing type after linking
            $this->Locations->calculateListingType($locationId);

            // Successfully linked! Send us to location review.
            $this->Flash->success('Location has been linked!');
            return $this->redirect('/admin/imports/location_review/' . $locationId . '/' . $importLocationId);
        }
        $this->set('importLocation', $importLocation);
        $this->set('importIndexReferer', $importIndexReferer);
    }

    public function locationUnlink($importLocationId) {
        $importLocation = $this->ImportLocations->get($importLocationId, [
            'contain' => ['Imports']
        ]);
        $locationId = $importLocation->location_id;
        $location = $this->Locations->get($locationId);

        if ($importLocation->import->type == 'cqp') {
            $location->id_cqp_practice = null;
            $location->id_cqp_office = null;
            $location->is_cqp = false;
            $location->cqp_tier = 0;
            $this->Locations->save($location);
        } else {
            $location->id_yhn_location = null;
            $location->is_yhn = false;
            $location->yhn_tier = 0;
            $this->Locations->save($location);
        }
        $this->Locations->calculateListingType($locationId);

        $importLocation->location_id = null;
        $importLocation->match_type = null;
        $this->ImportLocations->save($importLocation);

        // Successfully unlinked! Return us to the referring index page.
        $this->Flash->success('Location has been unlinked!');
        $importIndexReferer = $this->getImportIndexReferer();
        return $this->redirect($importIndexReferer);
    }

    public function locationAddJunk($importLocationId) {
        $importLocation = $this->ImportLocations->get($importLocationId, [
            'contain' => ['Imports']
        ]);
        if (empty($importLocation)) {
            $this->Flash->error('Import location could not be found.');
            return $this->redirect('/admin/imports');
        }
        $importIndexReferer = $this->getImportIndexReferer();
        $locationId = $importLocation->location_id;
        $isNew = empty($locationId);
        if ($isNew) {
            $location = $this->Locations->newEmptyEntity();
        } else {
            $location = $this->Locations->get($locationId);
        }
        // Junk/Competitor locations are always saved with inactive, no-show, LISTING_TYPE_NONE
        $locationData = [
            'yhn_location_id' => $importLocation->external_id,
            'oticon_id' => empty($importLocation->id_oticon) ? '' : $importLocation->id_oticon,
            'title' => $importLocation->title,
            'subtitle' => $importLocation->subtitle,
            'email' => $importLocation->email,
            'address' => $importLocation->address,
            'address_2' => $importLocation->address_2,
            'city' => $importLocation->city,
            'state' => $importLocation->state,
            'zip' => $importLocation->zip,
            'country' => Configure::read('country'),
            'phone' => $importLocation->phone,
            'is_retail' => $importLocation->is_retail,
            'review_needed' => 0,
            'listing_type' => Location::LISTING_TYPE_NONE,
            'is_active' => false,
            'is_show' => false,
            'payment' => $this->Location->defaultPayment,
            'filter_insurance' => true,
            'is_call_assist' => false,
            'is_junk' => true
        ];
        if ($importLocation->import->type == "yhn") {
            $locationData['is_yhn'] = true;
            $locationData['yhn_tier'] = 2;
        } else if ($importLocation->import->type == "cqp") {
            $locationData['is_cqp'] = true;
            $locationData['cqp_tier'] = 2;
            $locationData['id_cqp_practice'] = $importLocation->id_cqp_practice;
            $locationData['id_cqp_office'] = $importLocation->id_cqp_office;
        } else { // Canada
            $locationData['yhn_tier'] = 2;
        }

        $this->Locations->patchEntity($location, $locationData);
        $errors = $location->getErrors();
        if (empty($errors)) {
            $this->Locations->save($location);
        } else { // validation errors
            $this->flashValidationErrors($errors);
            return $this->redirect($importIndexReferer);
        }

        if ($isNew) {
            // Add a location user for new locations
            $locationId = $location->id;
            $this->Users->createClinicUserFromLocationId($locationId);
            $this->Locations->geoLocById($locationId);
        } else {
            // For existing locations, make sure the CS number is ended
            $this->Locations->CallSources->endCallSource($locationId);
        }

        $importLocation->location_id = $locationId;
        $importLocation->match_type = 4;
        $this->ImportLocations->save($importLocation);

        // Successfully added! Return us to the referring index page.
        if ($isNew) {
            $this->Flash->success('Location '.$locationId.' has been added and marked as junk');
        } else {
            $this->Flash->success('Existing location '.$locationId.' has been marked as junk');
        }
        $this->redirect($importIndexReferer);
    }

    public function locationNotJunk($locationId) {
        $location = $this->Locations->get($locationId);
        $location->is_junk = false;
        $this->Locations->save($location);
        $this->Flash->success('Location '.$locationId.' has been removed from junk');
        $importIndexReferer = $this->getImportIndexReferer();
        $this->redirect($importIndexReferer);
    }
}
