<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends BaseAdminController
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
            $this->set('currentModel', 'Cities');
        }
        $citiesQuery = $this->Cities
            ->find('search', [
                'search' => $requestParams,
            ]);
        $this->set('title', 'Cities Index');
        $this->set('cities', $this->paginate($citiesQuery));
        $this->set('fields', $this->Cities->getSchema()->typeMap());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $city = $this->Cities->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->Locations = $this->fetchTable('Locations');
            $data = $this->request->getData();
            $data['city'] = cleanCityName($data['city']);
            $data['state'] = $this->Locations->stateAbbr($data['state']);
            $data['country'] ??= Configure::read('country');
            // Only call Google API from prod.
            if (Configure::read('env') == 'prod') {
                $address = $data['city'].', '.$data['state'].', '.$data['country'];
                $originGeocode = $this->Locations->geoLocAddress($address);
                if (!empty($originGeocode[0])) {
                    $data['lat'] = $originGeocode[0];
                    $data['lon'] = $originGeocode[1];
                } else {
                    $this->Flash->error('The city could not be saved. Unable to get lat/lon from GeoLoc API.');
                    return false;
                }
            } else { // Local/Dev/QA
                // Save city with a generic lat/lon (37.0, -100.0) to keep the scripts from flagging this city as invalid
                $data['lat'] = 37.0;
                $data['lon'] = -99.0;
            }
            $city = $this->Cities->patchEntity($city, $data);
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $this->set('title', 'Add City');
        $this->set(compact('city'));
    }

    /**
     * Edit method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $city = $this->Cities->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $this->set('title', 'Edit City');
        $this->set(compact('city'));
    }

    /**
     * Delete method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $city = $this->Cities->get($id);
        if ($this->Cities->delete($city)) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
