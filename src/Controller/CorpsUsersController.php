<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CorpsUsers Controller
 *
 * @property \App\Model\Table\CorpsUsersTable $CorpsUsers
 * @method \App\Model\Entity\CorpsUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorpsUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Corps', 'Users'],
        ];
        $corpsUsers = $this->paginate($this->CorpsUsers);

        $this->set(compact('corpsUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Corps User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $corpsUser = $this->CorpsUsers->get($id, [
            'contain' => ['Corps', 'Users'],
        ]);

        $this->set(compact('corpsUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $corpsUser = $this->CorpsUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $corpsUser = $this->CorpsUsers->patchEntity($corpsUser, $this->request->getData());
            if ($this->CorpsUsers->save($corpsUser)) {
                $this->Flash->success(__('The corps user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corps user could not be saved. Please, try again.'));
        }
        $corps = $this->CorpsUsers->Corps->find('list', ['limit' => 200])->all();
        $users = $this->CorpsUsers->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('corpsUser', 'corps', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Corps User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $corpsUser = $this->CorpsUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $corpsUser = $this->CorpsUsers->patchEntity($corpsUser, $this->request->getData());
            if ($this->CorpsUsers->save($corpsUser)) {
                $this->Flash->success(__('The corps user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corps user could not be saved. Please, try again.'));
        }
        $corps = $this->CorpsUsers->Corps->find('list', ['limit' => 200])->all();
        $users = $this->CorpsUsers->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('corpsUser', 'corps', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Corps User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $corpsUser = $this->CorpsUsers->get($id);
        if ($this->CorpsUsers->delete($corpsUser)) {
            $this->Flash->success(__('The corps user has been deleted.'));
        } else {
            $this->Flash->error(__('The corps user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
