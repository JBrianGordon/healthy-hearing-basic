<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Event\EventInterface;

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
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $externalIdLabel = Configure::read('isYhnImportEnabled') ? 'YHN ID' : 'External ID';
        $this->set('externalIdLabel', $externalIdLabel);
    }

    public function getImportIndexReferer() {
        $referer = $this->request->getSession()->read('importIndexReferer');
        if (empty($referer)) {
            $referer = '/admin/import-locations';
        }
        return $referer;
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
            $this->redirect('/admin/imports');
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
                //['associated' => $associations]
            );
            if (!$this->Locations->save($location)) {
                $this->Flash->error('Failed to save location '.$locationId.'<br> > '.implode('<br> > ', array_column($this->Location->validationErrors, 0)));
                $this->redirect('/admin/imports');
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
            $this->redirect($importIndexReferer);
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
}
