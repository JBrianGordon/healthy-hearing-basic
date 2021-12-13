<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationNotes Controller
 *
 * @property \App\Model\Table\LocationNotesTable $LocationNotes
 * @method \App\Model\Entity\LocationNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationNotesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations', 'Users'],
        ];
        $locationNotes = $this->paginate($this->LocationNotes);

        $this->set(compact('locationNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Note id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationNote = $this->LocationNotes->get($id, [
            'contain' => ['Locations', 'Users'],
        ]);

        $this->set(compact('locationNote'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationNote = $this->LocationNotes->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationNote = $this->LocationNotes->patchEntity($locationNote, $this->request->getData());
            if ($this->LocationNotes->save($locationNote)) {
                $this->Flash->success(__('The location note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location note could not be saved. Please, try again.'));
        }
        $locations = $this->LocationNotes->Locations->find('list', ['limit' => 200])->all();
        $users = $this->LocationNotes->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('locationNote', 'locations', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Note id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationNote = $this->LocationNotes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationNote = $this->LocationNotes->patchEntity($locationNote, $this->request->getData());
            if ($this->LocationNotes->save($locationNote)) {
                $this->Flash->success(__('The location note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location note could not be saved. Please, try again.'));
        }
        $locations = $this->LocationNotes->Locations->find('list', ['limit' => 200])->all();
        $users = $this->LocationNotes->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('locationNote', 'locations', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationNote = $this->LocationNotes->get($id);
        if ($this->LocationNotes->delete($locationNote)) {
            $this->Flash->success(__('The location note has been deleted.'));
        } else {
            $this->Flash->error(__('The location note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
