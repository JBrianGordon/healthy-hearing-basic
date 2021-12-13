<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CaCallGroupNotes Controller
 *
 * @property \App\Model\Table\CaCallGroupNotesTable $CaCallGroupNotes
 * @method \App\Model\Entity\CaCallGroupNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallGroupNotesController extends AppController
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
        $caCallGroupNotes = $this->paginate($this->CaCallGroupNotes);

        $this->set(compact('caCallGroupNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Ca Call Group Note id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $caCallGroupNote = $this->CaCallGroupNotes->get($id, [
            'contain' => ['CaCallGroups', 'Users'],
        ]);

        $this->set(compact('caCallGroupNote'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $caCallGroupNote = $this->CaCallGroupNotes->newEmptyEntity();
        if ($this->request->is('post')) {
            $caCallGroupNote = $this->CaCallGroupNotes->patchEntity($caCallGroupNote, $this->request->getData());
            if ($this->CaCallGroupNotes->save($caCallGroupNote)) {
                $this->Flash->success(__('The ca call group note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call group note could not be saved. Please, try again.'));
        }
        $caCallGroups = $this->CaCallGroupNotes->CaCallGroups->find('list', ['limit' => 200])->all();
        $users = $this->CaCallGroupNotes->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('caCallGroupNote', 'caCallGroups', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ca Call Group Note id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $caCallGroupNote = $this->CaCallGroupNotes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $caCallGroupNote = $this->CaCallGroupNotes->patchEntity($caCallGroupNote, $this->request->getData());
            if ($this->CaCallGroupNotes->save($caCallGroupNote)) {
                $this->Flash->success(__('The ca call group note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call group note could not be saved. Please, try again.'));
        }
        $caCallGroups = $this->CaCallGroupNotes->CaCallGroups->find('list', ['limit' => 200])->all();
        $users = $this->CaCallGroupNotes->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('caCallGroupNote', 'caCallGroups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ca Call Group Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $caCallGroupNote = $this->CaCallGroupNotes->get($id);
        if ($this->CaCallGroupNotes->delete($caCallGroupNote)) {
            $this->Flash->success(__('The ca call group note has been deleted.'));
        } else {
            $this->Flash->error(__('The ca call group note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
