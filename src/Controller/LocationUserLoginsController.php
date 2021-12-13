<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationUserLogins Controller
 *
 * @property \App\Model\Table\LocationUserLoginsTable $LocationUserLogins
 * @method \App\Model\Entity\LocationUserLogin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationUserLoginsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['LocationUsers'],
        ];
        $locationUserLogins = $this->paginate($this->LocationUserLogins);

        $this->set(compact('locationUserLogins'));
    }

    /**
     * View method
     *
     * @param string|null $id Location User Login id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationUserLogin = $this->LocationUserLogins->get($id, [
            'contain' => ['LocationUsers'],
        ]);

        $this->set(compact('locationUserLogin'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationUserLogin = $this->LocationUserLogins->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationUserLogin = $this->LocationUserLogins->patchEntity($locationUserLogin, $this->request->getData());
            if ($this->LocationUserLogins->save($locationUserLogin)) {
                $this->Flash->success(__('The location user login has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location user login could not be saved. Please, try again.'));
        }
        $locationUsers = $this->LocationUserLogins->LocationUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('locationUserLogin', 'locationUsers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location User Login id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationUserLogin = $this->LocationUserLogins->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationUserLogin = $this->LocationUserLogins->patchEntity($locationUserLogin, $this->request->getData());
            if ($this->LocationUserLogins->save($locationUserLogin)) {
                $this->Flash->success(__('The location user login has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location user login could not be saved. Please, try again.'));
        }
        $locationUsers = $this->LocationUserLogins->LocationUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('locationUserLogin', 'locationUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location User Login id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationUserLogin = $this->LocationUserLogins->get($id);
        if ($this->LocationUserLogins->delete($locationUserLogin)) {
            $this->Flash->success(__('The location user login has been deleted.'));
        } else {
            $this->Flash->error(__('The location user login could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
