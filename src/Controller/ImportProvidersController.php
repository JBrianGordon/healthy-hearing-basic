<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ImportProviders Controller
 *
 * @property \App\Model\Table\ImportProvidersTable $ImportProviders
 * @method \App\Model\Entity\ImportProvider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportProvidersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Imports', 'Providers'],
        ];
        $importProviders = $this->paginate($this->ImportProviders);

        $this->set(compact('importProviders'));
    }

    /**
     * View method
     *
     * @param string|null $id Import Provider id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $importProvider = $this->ImportProviders->get($id, [
            'contain' => ['Imports', 'Providers', 'ImportLocationProviders'],
        ]);

        $this->set(compact('importProvider'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $importProvider = $this->ImportProviders->newEmptyEntity();
        if ($this->request->is('post')) {
            $importProvider = $this->ImportProviders->patchEntity($importProvider, $this->request->getData());
            if ($this->ImportProviders->save($importProvider)) {
                $this->Flash->success(__('The import provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import provider could not be saved. Please, try again.'));
        }
        $imports = $this->ImportProviders->Imports->find('list', ['limit' => 200])->all();
        $providers = $this->ImportProviders->Providers->find('list', ['limit' => 200])->all();
        $this->set(compact('importProvider', 'imports', 'providers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Import Provider id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $importProvider = $this->ImportProviders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $importProvider = $this->ImportProviders->patchEntity($importProvider, $this->request->getData());
            if ($this->ImportProviders->save($importProvider)) {
                $this->Flash->success(__('The import provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import provider could not be saved. Please, try again.'));
        }
        $imports = $this->ImportProviders->Imports->find('list', ['limit' => 200])->all();
        $providers = $this->ImportProviders->Providers->find('list', ['limit' => 200])->all();
        $this->set(compact('importProvider', 'imports', 'providers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Import Provider id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $importProvider = $this->ImportProviders->get($id);
        if ($this->ImportProviders->delete($importProvider)) {
            $this->Flash->success(__('The import provider has been deleted.'));
        } else {
            $this->Flash->error(__('The import provider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
