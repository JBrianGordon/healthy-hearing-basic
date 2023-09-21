<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Wikis Controller
 *
 * @property \App\Model\Table\WikisTable $Wikis
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WikisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $wikis = $this->paginate($this->Wikis);

        $this->set(compact('wikis'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wiki = $this->Wikis->newEmptyEntity();
        if ($this->request->is('post')) {
            $wiki = $this->Wikis->patchEntity($wiki, $this->request->getData());
            if ($this->Wikis->save($wiki)) {
                $this->Flash->success(__('The wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wiki could not be saved. Please, try again.'));
        }
        $users = $this->Wikis->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('wiki', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wiki id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wiki = $this->Wikis->get($id, [
            'contain' => ['Authors', 'Contributors', 'Reviewers', 'Tags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wiki = $this->Wikis->patchEntity($wiki, $this->request->getData());
            if ($this->Wikis->save($wiki)) {
                $this->Flash->success(__('The wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wiki could not be saved. Please, try again.'));
        }
        $authors = $this->Wikis->Authors->find('all', ['limit' => 200]);
        $this->set(compact('wiki', 'authors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wiki id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wiki = $this->Wikis->get($id);
        if ($this->Wikis->delete($wiki)) {
            $this->Flash->success(__('The wiki has been deleted.'));
        } else {
            $this->Flash->error(__('The wiki could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Draft method
     *
     * @param int $id Wikis id.
     * @return \Cake\Http\Response|null|void Redirects to existing or newly-created Wikis draft.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function draft(?int $id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $draftId = $this->Wikis->checkForDraft($id);

        if ($draftId > 0) {
            $this->Flash->success('This report has an existing draft below.');

            return $this->redirect(['action' => 'edit', $draftId]);
        }

        $newDraft = $this->Wikis->copy($id);

        return $this->redirect(['action' => 'edit', $newDraft->id]);
    }
}
