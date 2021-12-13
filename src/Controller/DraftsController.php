<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Drafts Controller
 *
 * @property \App\Model\Table\DraftsTable $Drafts
 * @method \App\Model\Entity\Draft[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DraftsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Models', 'Users'],
        ];
        $drafts = $this->paginate($this->Drafts);

        $this->set(compact('drafts'));
    }

    /**
     * View method
     *
     * @param string|null $id Draft id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $draft = $this->Drafts->get($id, [
            'contain' => ['Models', 'Users'],
        ]);

        $this->set(compact('draft'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $draft = $this->Drafts->newEmptyEntity();
        if ($this->request->is('post')) {
            $draft = $this->Drafts->patchEntity($draft, $this->request->getData());
            if ($this->Drafts->save($draft)) {
                $this->Flash->success(__('The draft has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The draft could not be saved. Please, try again.'));
        }
        $models = $this->Drafts->Models->find('list', ['limit' => 200])->all();
        $users = $this->Drafts->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('draft', 'models', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Draft id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $draft = $this->Drafts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $draft = $this->Drafts->patchEntity($draft, $this->request->getData());
            if ($this->Drafts->save($draft)) {
                $this->Flash->success(__('The draft has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The draft could not be saved. Please, try again.'));
        }
        $models = $this->Drafts->Models->find('list', ['limit' => 200])->all();
        $users = $this->Drafts->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('draft', 'models', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Draft id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $draft = $this->Drafts->get($id);
        if ($this->Drafts->delete($draft)) {
            $this->Flash->success(__('The draft has been deleted.'));
        } else {
            $this->Flash->error(__('The draft could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
