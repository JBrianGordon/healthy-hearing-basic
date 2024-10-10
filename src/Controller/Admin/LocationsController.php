<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends BaseAdminController
{
    use MailerAwareTrait;
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);

        $this->loadComponent('Export', [
            'actions' => ['export']
        ]);

        $this->loadComponent('PersistQueries', [
            'actions' => ['index'],
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $requestParams = $this->request->getQueryParams();
        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
            $this->set('currentModel', 'Locations');
        }
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()->where(['model' => 'Locations'])->toArray();
        $locationsQuery = $this->Locations
            ->find('search', [
                'search' => $requestParams,
            ]);
        $this->set('title', 'Locations index');
        $this->set('locations', $this->paginate($locationsQuery));
        $this->set('crmSearches', $crmSearches);
        $this->set('fields', $this->Locations->getSchema()->typeMap());
        $this->set('count', $locationsQuery->count());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Locations->newEmptyEntity();
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $mailer = $this->Locations->getMailer('ProfileMailer');
                $mailer->send('clinicDefaultEmail', [$location]);
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set('title', 'Add Location');
        $this->set(compact('location'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if (!$id) {
            return $this->redirect(['action' => 'add']);
        }
        $reviewLimit = empty($this->request->getQuery('loadall')) ? $this->Locations->Reviews->reviewLimit : null;
        $associations = [
            'CallSources',
            'LocationHours',
            'LocationAds',
            'LocationPhotos',
            'LocationVidscrips',
            'Providers',
            'LocationNotes' => [
                'sort' => ['LocationNotes.created' => 'DESC']
            ],
            'LocationEmails',
            'Users.LoginIps'
        ];
        $location = $this->Locations->get($id, [
            'contain' => $associations
        ]);
        $reviews = $this->Locations->Reviews->find('all', [
            'conditions' => ['location_id' => $id],
            'limit' => $reviewLimit,
            'sort' => ['Reviews.created' => 'DESC']
        ])->all();
        $lastOticonImport = $this->Locations->ImportStatus->find('all', [
            'contain' => [],
            'conditions' => [
                'location_id' => $id,
                'oticon_tier >' => 0
            ],
            'order' => ['ImportStatus.created DESC']
        ])->first();
        $lastOticonImportDate = empty($lastOticonImport->created) ? 'N/A' : dateTimeCentralToEastern($lastOticonImport->created);
        $oticonImportStatuses = $this->Locations->ImportStatus->find('all', [
            'conditions' => ['location_id' => $id],
            'limit' => $reviewLimit,
            'order' => ['ImportStatus.created DESC']
        ])->all();
        $importLocations = $this->Locations->ImportLocations->find('all', [
            'contain' => ['Imports'],
            'conditions' => ['location_id' => $id],
            'order' => ['ImportLocations.import_id DESC']
        ])->all();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // convert payment array to json string
            $data['payment'] = isset($data['payment']) ? json_encode($data['payment']) : "";
            // remove empty providers
            foreach ($data['providers'] as $key => $provider) {
                if (empty($provider['id']) && empty($provider['first_name'])) {
                    unset($data['providers'][$key]);
                }
            }
            // remove empty location emails
            foreach ($data['location_emails'] as $key => $locationEmail) {
                if (empty($locationEmail['id']) && empty($locationEmail['email'])) {
                    unset($data['location_emails'][$key]);
                }
            }
            // remove empty location notes
            foreach ($data['location_notes'] as $key => $locationNote) {
                if (empty($locationNote['body'])) {
                    unset($data['location_notes'][$key]);
                }
            }
            $location = $this->Locations->patchEntity(
                $location,
                $data,
                ['associated' => $associations]
            );
            if ($this->Locations->save($location)) {
                $mailer = $this->Locations->getMailer('ProfileMailer');
                if($location['listing_type'] === "Basic" && $location['is_retail'] === false) {
                    $mailer->send('upgradeProfile', [$location]);
                } else {
                    $mailer->send('profileUpdate', [$location]);
                }
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect($this->request->referer());
            }
            $this->Flash->error('The location could not be saved.<br>' . $this->displayErrors($location->getErrors()), ['escape' => false]);
        }
        $this->set('title', 'Edit ' . $location->title);
        $this->set(compact('location', 'lastOticonImportDate', 'importLocations', 'oticonImportStatuses', 'reviews'));
        $this->set('uniqueLocationLinks', $this->Locations->findUniqueLocationLinks($id));
        $this->set('days', $this->Locations->LocationHours->days);
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
    * Export a list of calls to CSV
    */
    function export() {
        $this->autoRender = false;
        $queryString = str_replace('?', '', $this->request->getData('queryString'));
        parse_str(str_replace('?', '', $queryString), $query);
        $excludedFields = $this->request->getData('excludedFields');

        // Becky TODO #16839: call LocationsTable::export() with $query and $excludedFields to get the export data.
        // TODO: set ignore fields, additional fields, and overwrite fields. See CaCallsController for example.
        //$this->response = $this->response->withDownload('export_locations.csv');

        //TODO: Remove this. Temporary test response
        $return = ['success' => true, 'query' => $query, 'excludedFields' => $excludedFields];
        return $this->response->withStringBody(json_encode($return));
    }

    /**
    * Export a list of emails for the selected locations
    */
    public function emailsCsv() {
        $this->response = $this->response->withDownload('export_location_emails.csv');
        $requestParams = $this->request->getQueryParams();
        $options = [
            'search' => $requestParams,
            'contain' => ['Users', 'LocationEmails', 'Providers'],
        ];
        // TODO: So far, this seems to work okay even for larger exports.
        //     : But in Cake2 we sent large exports to the queue. Do we need to do the same?
        //$locationsQuery = $this->Locations->find('search', $options);
        //$count = $locationsQuery->count();
        $emails = $this->Locations->exportEmails($options);
        $_serialize = 'emails';
        $_header = ['ID', 'Clinic Title', 'First Name', 'Last Name', 'Email'];
        $_extract = ['hhid', 'clinic_title', 'first_name', 'last_name', 'email'];

        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('emails', '_serialize', '_header', '_extract'));
    }

    /**
    * Runs a Tier Status Change report and sends the results via email
    */
    public function tierStatusReport() {
        $requestData = $this->request->getData();
        $email = $requestData['email'] ?? $this->user->email;
        if (!empty($requestData)) {
            // Large file. Dispatch shell.
            $this->QueuedJobs = TableRegistry::get('Queue.QueuedJobs');
            $cmd = "tier_status_change";
            if (!empty($requestData['email'])) {
                $cmd .= ' -t '.$email;
            }
            if (!empty($requestData['start_date'])) {
                $cmd .= ' -s '.$requestData['start_date'];
            }
            if (!empty($requestData['end_date'])) {
                $cmd .= ' -e '.$requestData['end_date'];
            }
            $data = ['vars' => ['command' => $cmd]];
            if ($this->QueuedJobs->createJob('Shell', $data)) {
                $this->Flash->success('The tier status change report will be emailed.');
            } else {
                $this->Flash->error('Unable to add to queue: '.$cmd);
            }
            return $this->redirect(['action' => 'tier-status-report']);
        }
    }

    // Create or update the CallSource number for this location
    public function createUpdateCallSource($locationId = 0) {
        // Since this is a manual method of modifying CS numbers with the button press,
        // we can allow CS access on the test account
        $this->Locations->CallSources->allowCsTest();
        $result = $this->Locations->CallSources->saveCallSource($locationId);
        $this->Locations->CallSources->disallowCsTest();
        if ($result) {
            $this->Flash->success('Call Source Number created/updated successfully!');
        } else {
            $errors = r_implode('<br>',$this->Locations->CallSources->errors);
            $this->Flash->error("Unable to obtain number from CallSource.<br>Error(s): " . $errors, ['escape' => false]);
        }
        return $this->redirect(['action' => 'edit', $locationId, '#'=>'CallSource']);
    }

    // End the CS number and create a new one for this location
    public function csEndCreate($locationId = 0) {
        // End the number but do not inactivate the customer
        if ($this->Locations->CallSources->endCallSource($locationId, false)) {
            // Number ended successfully. Create new number.
            // Allow CS access on the test account
            $this->Locations->CallSources->allowCsTest();
            $result = $this->Locations->CallSources->saveCallSource($locationId);
            $this->Locations->CallSources->disallowCsTest();
            if ($result) {
                $this->Flash->success('CS number ended and new number created successfully.');
            } else {
                $errors = r_implode('<br>',$this->Locations->CallSources->errors);
                $this->Flash->error('Failed to create new CallSource number.<br>Error(s): ' . $errors, ['escape' => false]);
            }
        } else {
            $errors = r_implode('<br>', $this->Locations->CallSources->errors);
            $this->Flash->error('Unable to end CallSource number.<br>Error(s): ' . $errors, ['escape' => false]);
        }
        return $this->redirect(['action' => 'edit', $locationId, '#'=>'CallSource']);
    }

    // End the CS number for this location
    public function csEnd($locationId = 0) {
        // End all campaigns and inactivate the customer
        if ($this->Locations->CallSources->endCallSource($locationId)) {
            $this->Flash->success('CallSource number(s) ended successfully!');
        } else {
            $errors = r_implode('<br>', $this->Locations->CallSources->errors);
            $this->Flash->error('Unable to end CallSource number.<br>Error(s): ' . $errors, ['escape' => false]);
        }
        return $this->redirect(['action' => 'edit', $locationId, '#'=>'CallSource']);
    }

    /**
    * Simple callsource raw lookup
    */
    public function callSourceRaw($locationId = 0) {
        Configure::write('debug', true);
        $this->set('call_source', $this->Locations->CallSources->customerLookup($locationId));
        $this->set('locationId', $locationId);
    }

    /**
    * Simple callsource raw lookup
    */
    private function displayErrors($errors) {
        $displayErrors = [];
        foreach ($errors as $key => $error) {
            if (is_array($error)) {
                foreach ($error as $nestedKey => $nestedError) {
                    $displayErrors[] = $key.'->'.$nestedKey.': '.implode($nestedError);
                }
            } else {
                $displayErrors[] = $key.': '.print_r($error);
            }
        }
        return r_implode('<br>', $displayErrors);
    }
}
