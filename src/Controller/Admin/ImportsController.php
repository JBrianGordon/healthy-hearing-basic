<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Imports Controller
 *
 * @property \App\Model\Table\ImportsTable $Imports
 * @method \App\Model\Entity\Import[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportsController extends AppController
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

        $this->paginate = [
            'order' => ['Imports.id' => 'DESC']
        ];
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
            $this->set('currentModel', 'Imports');
        }
        $importsQuery = $this->Imports->find('search', [
            'search' => $requestParams,
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
}
