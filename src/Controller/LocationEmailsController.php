<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationEmails Controller
 *
 * @property \App\Model\Table\LocationEmailsTable $LocationEmails
 * @method \App\Model\Entity\LocationEmail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationEmailsController extends AppController
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
        $locationEmails = $this->paginate($this->LocationEmails);

        $this->set(compact('locationEmails'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Email id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationEmail = $this->LocationEmails->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationEmail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationEmail = $this->LocationEmails->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationEmail = $this->LocationEmails->patchEntity($locationEmail, $this->request->getData());
            if ($this->LocationEmails->save($locationEmail)) {
                $this->Flash->success(__('The location email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location email could not be saved. Please, try again.'));
        }
        $locations = $this->LocationEmails->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationEmail', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Email id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationEmail = $this->LocationEmails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationEmail = $this->LocationEmails->patchEntity($locationEmail, $this->request->getData());
            if ($this->LocationEmails->save($locationEmail)) {
                $this->Flash->success(__('The location email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location email could not be saved. Please, try again.'));
        }
        $locations = $this->LocationEmails->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationEmail', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Email id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationEmail = $this->LocationEmails->get($id);
        if ($this->LocationEmails->delete($locationEmail)) {
            $this->Flash->success(__('The location email has been deleted.'));
        } else {
            $this->Flash->error(__('The location email could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
