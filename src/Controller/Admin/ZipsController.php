<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Zips Controller
 *
 * @method \App\Model\Entity\Zip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ZipsController extends BaseAdminController
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
            $this->set('currentModel', 'Zips');
        }
        $zipsQuery = $this->Zips
            ->find('search', [
                'search' => $requestParams,
            ]);
        $this->set('title', Configure::read('zipLabel') . ' Index');
        $this->set('zips', $this->paginate($zipsQuery));
        $this->set('fields', $this->Zips->getSchema()->typeMap());
        $this->set('zipLabel', Configure::read('zipLabel'));
        $this->set('zipShort', Configure::read('zipShort'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $zip = $this->Zips->newEmptyEntity();
        $zipLabel = Configure::read('zipLabel');

        if ($this->request->is('post')) {
            $this->Locations = $this->fetchTable('Locations');
            $data = $this->request->getData();
            $data['country'] ??= Configure::read('country');
            $geoloc = $this->Locations->geoLocAddress($data['zip'].', '.$data['country']);
            if (empty($geoloc['lat']) || empty($geoloc['lon'])) {
                $this->Flash->error('The '.$zipLabel.' could not be saved. Unable to get lat/lon from GeoLoc API.');
                return;
            }
            $geoloc['city'] = cleanCityName($geoloc['city']);
            $geoloc['state'] = $this->Locations->stateAbbr($geoloc['state']);
            $geoloc['country_code'] = $geoloc['country'];

            $zip = $this->Zips->patchEntity($zip, $geoloc);
            if ($this->Zips->save($zip)) {
                $this->Flash->success('The '.$zipLabel.'  has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The '.$zipLabel.' could not be saved. Please, try again.');
        }
        $this->set('title', 'Add ' . $zipLabel);
        $this->set(compact('zip'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Zip id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $zip = $this->Zips->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $zip = $this->Zips->patchEntity($zip, $this->request->getData());

            if ($this->Zips->save($zip)) {
                $this->Flash->success(__('The zip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The zip could not be saved. Please, try again.'));
        }
        $this->set('title', 'Edit ' . Configure::read('zipLabel'));
        $this->set(compact('zip'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Zip id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $zip = $this->Zips->get($id);
        if ($this->Zips->delete($zip)) {
            $this->Flash->success(__('The zip has been deleted.'));
        } else {
            $this->Flash->error(__('The zip could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
