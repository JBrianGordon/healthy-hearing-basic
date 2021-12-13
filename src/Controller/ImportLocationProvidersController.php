<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ImportLocationProviders Controller
 *
 * @property \App\Model\Table\ImportLocationProvidersTable $ImportLocationProviders
 * @method \App\Model\Entity\ImportLocationProvider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportLocationProvidersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Imports', 'ImportLocations', 'ImportProviders'],
        ];
        $importLocationProviders = $this->paginate($this->ImportLocationProviders);

        $this->set(compact('importLocationProviders'));
    }

    /**
     * View method
     *
     * @param string|null $id Import Location Provider id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $importLocationProvider = $this->ImportLocationProviders->get($id, [
            'contain' => ['Imports', 'ImportLocations', 'ImportProviders'],
        ]);

        $this->set(compact('importLocationProvider'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $importLocationProvider = $this->ImportLocationProviders->newEmptyEntity();
        if ($this->request->is('post')) {
            $importLocationProvider = $this->ImportLocationProviders->patchEntity($importLocationProvider, $this->request->getData());
            if ($this->ImportLocationProviders->save($importLocationProvider)) {
                $this->Flash->success(__('The import location provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import location provider could not be saved. Please, try again.'));
        }
        $imports = $this->ImportLocationProviders->Imports->find('list', ['limit' => 200])->all();
        $importLocations = $this->ImportLocationProviders->ImportLocations->find('list', ['limit' => 200])->all();
        $importProviders = $this->ImportLocationProviders->ImportProviders->find('list', ['limit' => 200])->all();
        $this->set(compact('importLocationProvider', 'imports', 'importLocations', 'importProviders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Import Location Provider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $importLocationProvider = $this->ImportLocationProviders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $importLocationProvider = $this->ImportLocationProviders->patchEntity($importLocationProvider, $this->request->getData());
            if ($this->ImportLocationProviders->save($importLocationProvider)) {
                $this->Flash->success(__('The import location provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import location provider could not be saved. Please, try again.'));
        }
        $imports = $this->ImportLocationProviders->Imports->find('list', ['limit' => 200])->all();
        $importLocations = $this->ImportLocationProviders->ImportLocations->find('list', ['limit' => 200])->all();
        $importProviders = $this->ImportLocationProviders->ImportProviders->find('list', ['limit' => 200])->all();
        $this->set(compact('importLocationProvider', 'imports', 'importLocations', 'importProviders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Import Location Provider id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $importLocationProvider = $this->ImportLocationProviders->get($id);
        if ($this->ImportLocationProviders->delete($importLocationProvider)) {
            $this->Flash->success(__('The import location provider has been deleted.'));
        } else {
            $this->Flash->error(__('The import location provider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
