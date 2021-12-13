<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CaCalls Controller
 *
 * @property \App\Model\Table\CaCallsTable $CaCalls
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CaCallGroups', 'Users'],
        ];
        $caCalls = $this->paginate($this->CaCalls);

        $this->set(compact('caCalls'));
    }

    /**
     * View method
     *
     * @param string|null $id Ca Call id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $caCall = $this->CaCalls->get($id, [
            'contain' => ['CaCallGroups', 'Users'],
        ]);

        $this->set(compact('caCall'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $caCall = $this->CaCalls->newEmptyEntity();
        if ($this->request->is('post')) {
            $caCall = $this->CaCalls->patchEntity($caCall, $this->request->getData());
            if ($this->CaCalls->save($caCall)) {
                $this->Flash->success(__('The ca call has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call could not be saved. Please, try again.'));
        }
        $caCallGroups = $this->CaCalls->CaCallGroups->find('list', ['limit' => 200])->all();
        $users = $this->CaCalls->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('caCall', 'caCallGroups', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ca Call id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $caCall = $this->CaCalls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $caCall = $this->CaCalls->patchEntity($caCall, $this->request->getData());
            if ($this->CaCalls->save($caCall)) {
                $this->Flash->success(__('The ca call has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call could not be saved. Please, try again.'));
        }
        $caCallGroups = $this->CaCalls->CaCallGroups->find('list', ['limit' => 200])->all();
        $users = $this->CaCalls->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('caCall', 'caCallGroups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ca Call id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $caCall = $this->CaCalls->get($id);
        if ($this->CaCalls->delete($caCall)) {
            $this->Flash->success(__('The ca call has been deleted.'));
        } else {
            $this->Flash->error(__('The ca call could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
