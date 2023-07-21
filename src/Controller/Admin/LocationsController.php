<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{
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
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
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
        $reviewLimit = !empty($this->request->getQuery('loadall')) ? 99999 : $this->Locations->Reviews->reviewLimit;
        $location = $this->Locations->get($id, [
            'contain' => ['CallSources', 'LocationHours', 'LocationAds', 'LocationPhotos', 'LocationVidscrips', 'Providers'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $this->set(compact('location'));
        $this->set('uniqueLocationLinks', $this->Locations->findUniqueLocationLinks($id));
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
        $requestParams = $this->request->getQueryParams();

        // TODO: set ignore fields, additional fields, and overwrite fields. See CaCallsController for example.
        $this->Export->exportCsv('export_locations.csv');
        die();
    }

    /**
    * Export a list of emails for the selected locations
    */
    public function emails() {
        //TODO
        /*
        $this->helpers[] = 'Icing.Csv';
        $this->layout = 'csv';
        if ($this->request->ext != 'csv') {
            $this->redirect(['action' => 'export', 'ext' => 'csv']);
        }
        $options = [
            'contain' => ['LocationUser', 'LocationEmail', 'Provider'],
            'fields' => ['Location.id','Location.title','Location.email','LocationUser.first_name','LocationUser.last_name','LocationUser.email'],
        ];
        if (isset($this->request->params['named']['search'])) {
            $options['conditions'] = $this->Location->search($this->request->params['named']['search']);
        }
        $count = $this->Location->find('count', ['conditions' => $options['conditions']]);
        // We run into memory errors if we try to download a file that is too large
        if ($count <= 2000) {
            // Small file. Download immediately.
            $this->set('filename','export_location_emails.csv');
            $this->set('data', $this->Location->exportEmails($options));
        } else {
            // Large file. Dispatch shell.
            App::uses('Queue','Queue.Lib');
            $email = $this->Auth->user('email');
            $exportParams = [
                'email' => $email,
                'options' => $options
            ];
            $cmd = "locations exportEmails ".json_encode($exportParams);
            if (Queue::add($cmd, 'shell')) {
                $this->goodFlash('Large file export. Results will be emailed.');
            } else {
                $this->badFlash('Unable to add to queue: '.$cmd);
            }
            return $this->redirect(['action' => 'index']);
        }*/
    }
}
