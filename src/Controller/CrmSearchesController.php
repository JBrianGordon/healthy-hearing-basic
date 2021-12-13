<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CrmSearches Controller
 *
 * @property \App\Model\Table\CrmSearchesTable $CrmSearches
 * @method \App\Model\Entity\CrmSearch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CrmSearchesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $crmSearches = $this->paginate($this->CrmSearches);

        $this->set(compact('crmSearches'));
    }

    /**
     * View method
     *
     * @param string|null $id Crm Search id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $crmSearch = $this->CrmSearches->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('crmSearch'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $crmSearch = $this->CrmSearches->newEmptyEntity();
        if ($this->request->is('post')) {
            $crmSearch = $this->CrmSearches->patchEntity($crmSearch, $this->request->getData());
            if ($this->CrmSearches->save($crmSearch)) {
                $this->Flash->success(__('The crm search has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The crm search could not be saved. Please, try again.'));
        }
        $users = $this->CrmSearches->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('crmSearch', 'users'));
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
        $crmSearch = $this->CrmSearches->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $crmSearch = $this->CrmSearches->patchEntity($crmSearch, $this->request->getData());
            if ($this->CrmSearches->save($crmSearch)) {
                $this->Flash->success(__('The crm search has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The crm search could not be saved. Please, try again.'));
        }
        $users = $this->CrmSearches->Users->find('list', ['limit' => 200])->all();
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

        return $this->redirect(['action' => 'index']);
    }
}
