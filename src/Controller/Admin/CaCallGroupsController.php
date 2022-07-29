<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CaCallGroups Controller
 *
 * @property \App\Model\Table\CaCallGroupsTable $CaCallGroups
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallGroupsController extends AppController
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
        }
        $caCallGroupsQuery = $this->CaCallGroups
            ->find('search', [
                'search' => $requestParams,
                'contain' => ['Locations'],
            ]);
        $this->set('caCallGroups', $this->paginate($caCallGroupsQuery));
        $this->set('fields', $this->CaCallGroups->getSchema()->typeMap());
    }

    /**
     * View method
     *
     * @param string|null $id Ca Call Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $caCallGroup = $this->CaCallGroups->get($id, [
            'contain' => ['Locations', 'CaCallGroupNotes', 'CaCalls'],
        ]);

        $this->set(compact('caCallGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ca Call Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $caCallGroup = $this->CaCallGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $caCallGroup = $this->CaCallGroups->patchEntity($caCallGroup, $this->request->getData());
            if ($this->CaCallGroups->save($caCallGroup)) {
                $this->Flash->success(__('The ca call group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call group could not be saved. Please, try again.'));
        }
        $locations = $this->CaCallGroups->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('caCallGroup', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ca Call Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $caCallGroup = $this->CaCallGroups->get($id);
        if ($this->CaCallGroups->delete($caCallGroup)) {
            $this->Flash->success(__('The ca call group has been deleted.'));
        } else {
            $this->Flash->error(__('The ca call group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
