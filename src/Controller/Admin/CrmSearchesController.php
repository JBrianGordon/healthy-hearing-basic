<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * CrmSearches Controller
 *
 * @property \App\Model\Table\CrmSearchesTable $CrmSearches
 * @method \App\Model\Entity\CrmSearch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CrmSearchesController extends BaseAdminController
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
            $this->set('currentModel', 'CrmSearches');
        }
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()->where(['model' => 'CrmSearches'])->toArray();
        $crmSearchQuery = $this->CrmSearches->find('search', [
            'search' => $requestParams,
            'contain' => ['Users']
        ]);

        $this->set('allCrmSearches', $this->paginate($crmSearchQuery));
        $this->set('crmSearches', $crmSearches);
        $this->set('fields', $this->CrmSearches->getSchema()->typeMap());
        $this->set('users', $this->CrmSearches->findCrmSearchUsers());
    }

    /**
     * Edit method
     *
     * @param string|null $id Crm Search id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($id !== null) {
            $crmSearch = $this->CrmSearches->get($id, [
                'contain' => [],
            ]);
        } else {
            $this->Flash->warning('To create a saved search, run a search.');
            return $this->redirect(['admin' => true, 'controller' => 'locations', 'action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $crmSearch = $this->CrmSearches->patchEntity($crmSearch, $this->request->getData());
            if ($this->CrmSearches->save($crmSearch)) {
                $this->Flash->success(__('The crm search has been saved.'));

                return $this->redirect([
                    'controller' => $crmSearch->model,
                    'prefix' => 'Admin',
                    'action' => 'index',
                ]);
            }
            $this->Flash->error(__('The crm search could not be saved. Please, try again.'));
        }

        $users = $this->CrmSearches->Users->find('list', ['keyField' => 'id','valueField' => 'username'])->toArray();
        $this->set(compact('crmSearch', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Crm Search id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $crmSearch = $this->CrmSearches->get($id);

        if ($this->CrmSearches->delete($crmSearch)) {
            $this->Flash->success(__('The crm search has been deleted.'));
        } else {
            $this->Flash->error(__('The crm search could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'controller' => $crmSearch->model,
            'prefix' => 'Admin',
            'action' => 'index',
        ]);
    }

    /**
     * Save method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful or unsucessful save.
     */
    public function save()
    {
        $this->disableAutoRender();

        $data = $this->request->getData();
        $data['searchData']['saved_search'] = true;

        $saveData = [
             'search' => json_encode($data['searchData']),
             'title' => 'Saved Query',
             'user_id' => $data['userId'],
             'is_public' => true,
             'model' => $data['model'],
        ];

        $crmSearch = $this->CrmSearches->newEmptyEntity();
        if ($this->request->is('post')) {
            $crmSearch = $this->CrmSearches->patchEntity($crmSearch, $saveData);
            if ($this->CrmSearches->save($crmSearch)) {
                $this->Flash->success(__('The crm search has been saved.'));
                return $this->redirect([
                    'controller' => $crmSearch->model,
                    'prefix' => 'Admin',
                    'action' => 'index',
                ]);
            }
            $this->Flash->error(__('The crm search could not be saved. Please, try again.'));

            return $this->redirect([
                'controller' => $crmSearch->model,
                'prefix' => 'Admin',
                'action' => 'index',
            ]);
        }
    }
}
