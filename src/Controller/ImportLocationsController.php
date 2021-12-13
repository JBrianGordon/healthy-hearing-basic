<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ImportLocations Controller
 *
 * @property \App\Model\Table\ImportLocationsTable $ImportLocations
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportLocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Imports', 'Locations'],
        ];
        $importLocations = $this->paginate($this->ImportLocations);

        $this->set(compact('importLocations'));
    }

    /**
     * View method
     *
     * @param string|null $id Import Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $importLocation = $this->ImportLocations->get($id, [
            'contain' => ['Imports', 'Locations', 'ImportLocationProviders'],
        ]);

        $this->set(compact('importLocation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $importLocation = $this->ImportLocations->newEmptyEntity();
        if ($this->request->is('post')) {
            $importLocation = $this->ImportLocations->patchEntity($importLocation, $this->request->getData());
            if ($this->ImportLocations->save($importLocation)) {
                $this->Flash->success(__('The import location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import location could not be saved. Please, try again.'));
        }
        $imports = $this->ImportLocations->Imports->find('list', ['limit' => 200])->all();
        $locations = $this->ImportLocations->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('importLocation', 'imports', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Import Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $importLocation = $this->ImportLocations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $importLocation = $this->ImportLocations->patchEntity($importLocation, $this->request->getData());
            if ($this->ImportLocations->save($importLocation)) {
                $this->Flash->success(__('The import location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import location could not be saved. Please, try again.'));
        }
        $imports = $this->ImportLocations->Imports->find('list', ['limit' => 200])->all();
        $locations = $this->ImportLocations->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('importLocation', 'imports', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Import Location id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $importLocation = $this->ImportLocations->get($id);
        if ($this->ImportLocations->delete($importLocation)) {
            $this->Flash->success(__('The import location has been deleted.'));
        } else {
            $this->Flash->error(__('The import location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
