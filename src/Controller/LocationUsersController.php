<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationUsers Controller
 *
 * @property \App\Model\Table\LocationUsersTable $LocationUsers
 * @method \App\Model\Entity\LocationUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations'],
        ];
        $locationUsers = $this->paginate($this->LocationUsers);

        $this->set(compact('locationUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Location User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationUser = $this->LocationUsers->get($id, [
            'contain' => ['Locations', 'LocationUserLogins'],
        ]);

        $this->set(compact('locationUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationUser = $this->LocationUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationUser = $this->LocationUsers->patchEntity($locationUser, $this->request->getData());
            if ($this->LocationUsers->save($locationUser)) {
                $this->Flash->success(__('The location user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location user could not be saved. Please, try again.'));
        }
        $locations = $this->LocationUsers->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationUser', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationUser = $this->LocationUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationUser = $this->LocationUsers->patchEntity($locationUser, $this->request->getData());
            if ($this->LocationUsers->save($locationUser)) {
                $this->Flash->success(__('The location user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location user could not be saved. Please, try again.'));
        }
        $locations = $this->LocationUsers->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationUser', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationUser = $this->LocationUsers->get($id);
        if ($this->LocationUsers->delete($locationUser)) {
            $this->Flash->success(__('The location user has been deleted.'));
        } else {
            $this->Flash->error(__('The location user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
