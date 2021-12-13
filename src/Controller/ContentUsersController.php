<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContentUsers Controller
 *
 * @property \App\Model\Table\ContentUsersTable $ContentUsers
 * @method \App\Model\Entity\ContentUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contents', 'Users', 'Content'],
        ];
        $contentUsers = $this->paginate($this->ContentUsers);

        $this->set(compact('contentUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Content User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contentUser = $this->ContentUsers->get($id, [
            'contain' => ['Contents', 'Users', 'Content'],
        ]);

        $this->set(compact('contentUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentUser = $this->ContentUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $contentUser = $this->ContentUsers->patchEntity($contentUser, $this->request->getData());
            if ($this->ContentUsers->save($contentUser)) {
                $this->Flash->success(__('The content user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content user could not be saved. Please, try again.'));
        }
        $contents = $this->ContentUsers->Contents->find('list', ['limit' => 200])->all();
        $users = $this->ContentUsers->Users->find('list', ['limit' => 200])->all();
        $content = $this->ContentUsers->Content->find('list', ['limit' => 200])->all();
        $this->set(compact('contentUser', 'contents', 'users', 'content'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentUser = $this->ContentUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentUser = $this->ContentUsers->patchEntity($contentUser, $this->request->getData());
            if ($this->ContentUsers->save($contentUser)) {
                $this->Flash->success(__('The content user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content user could not be saved. Please, try again.'));
        }
        $contents = $this->ContentUsers->Contents->find('list', ['limit' => 200])->all();
        $users = $this->ContentUsers->Users->find('list', ['limit' => 200])->all();
        $content = $this->ContentUsers->Content->find('list', ['limit' => 200])->all();
        $this->set(compact('contentUser', 'contents', 'users', 'content'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contentUser = $this->ContentUsers->get($id);
        if ($this->ContentUsers->delete($contentUser)) {
            $this->Flash->success(__('The content user has been deleted.'));
        } else {
            $this->Flash->error(__('The content user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
