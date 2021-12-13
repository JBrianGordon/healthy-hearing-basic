<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationProviders Controller
 *
 * @property \App\Model\Table\LocationProvidersTable $LocationProviders
 * @method \App\Model\Entity\LocationProvider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationProvidersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Providers'],
        ];
        $locationProviders = $this->paginate($this->LocationProviders);

        $this->set(compact('locationProviders'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Provider id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationProvider = $this->LocationProviders->get($id, [
            'contain' => ['Locations', 'Providers'],
        ]);

        $this->set(compact('locationProvider'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationProvider = $this->LocationProviders->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationProvider = $this->LocationProviders->patchEntity($locationProvider, $this->request->getData());
            if ($this->LocationProviders->save($locationProvider)) {
                $this->Flash->success(__('The location provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location provider could not be saved. Please, try again.'));
        }
        $locations = $this->LocationProviders->Locations->find('list', ['limit' => 200])->all();
        $providers = $this->LocationProviders->Providers->find('list', ['limit' => 200])->all();
        $this->set(compact('locationProvider', 'locations', 'providers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Provider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationProvider = $this->LocationProviders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationProvider = $this->LocationProviders->patchEntity($locationProvider, $this->request->getData());
            if ($this->LocationProviders->save($locationProvider)) {
                $this->Flash->success(__('The location provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location provider could not be saved. Please, try again.'));
        }
        $locations = $this->LocationProviders->Locations->find('list', ['limit' => 200])->all();
        $providers = $this->LocationProviders->Providers->find('list', ['limit' => 200])->all();
        $this->set(compact('locationProvider', 'locations', 'providers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Provider id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationProvider = $this->LocationProviders->get($id);
        if ($this->LocationProviders->delete($locationProvider)) {
            $this->Flash->success(__('The location provider has been deleted.'));
        } else {
            $this->Flash->error(__('The location provider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
