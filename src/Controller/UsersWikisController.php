<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UsersWikis Controller
 *
 * @property \App\Model\Table\UsersWikisTable $UsersWikis
 * @method \App\Model\Entity\UsersWiki[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersWikisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Wikis', 'Users'],
        ];
        $usersWikis = $this->paginate($this->UsersWikis);

        $this->set(compact('usersWikis'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Wiki id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersWiki = $this->UsersWikis->get($id, [
            'contain' => ['Wikis', 'Users'],
        ]);

        $this->set(compact('usersWiki'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersWiki = $this->UsersWikis->newEmptyEntity();
        if ($this->request->is('post')) {
            $usersWiki = $this->UsersWikis->patchEntity($usersWiki, $this->request->getData());
            if ($this->UsersWikis->save($usersWiki)) {
                $this->Flash->success(__('The users wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users wiki could not be saved. Please, try again.'));
        }
        $wikis = $this->UsersWikis->Wikis->find('list', ['limit' => 200])->all();
        $users = $this->UsersWikis->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('usersWiki', 'wikis', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Wiki id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersWiki = $this->UsersWikis->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersWiki = $this->UsersWikis->patchEntity($usersWiki, $this->request->getData());
            if ($this->UsersWikis->save($usersWiki)) {
                $this->Flash->success(__('The users wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users wiki could not be saved. Please, try again.'));
        }
        $wikis = $this->UsersWikis->Wikis->find('list', ['limit' => 200])->all();
        $users = $this->UsersWikis->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('usersWiki', 'wikis', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Wiki id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersWiki = $this->UsersWikis->get($id);
        if ($this->UsersWikis->delete($usersWiki)) {
            $this->Flash->success(__('The users wiki has been deleted.'));
        } else {
            $this->Flash->error(__('The users wiki could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
