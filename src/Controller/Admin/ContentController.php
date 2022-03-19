<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Content Controller
 *
 * @property \App\Model\Table\ContentTable $Content
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $content = $this->paginate($this->Content);

        $this->set(compact('content'));
    }

    /**
     * View method
     *
     * @param string|null $id Content id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['Users', 'Locations', 'Tags'],
        ]);

        $this->set(compact('content'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $content = $this->Content->newEmptyEntity();
        if ($this->request->is('post')) {
            $content = $this->Content->patchEntity($content, $this->request->getData());
            if ($this->Content->save($content)) {
                $this->Flash->success(__('The content has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content could not be saved. Please, try again.'));
        }
        $users = $this->Content->Users->find('list', ['limit' => 200])->all();
        $locations = $this->Content->Locations->find('list', ['limit' => 200])->all();
        $tags = $this->Content->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('content', 'users', 'locations', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['PrimaryAuthor', 'Contributors'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Content->patchEntity($content, $this->request->getData());
            if ($this->Content->save($content)) {
                $this->Flash->success(__('The content has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content could not be saved. Please, try again.'));
        }
        $this->set(compact('content'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $content = $this->Content->get($id);
        if ($this->Content->delete($content)) {
            $this->Flash->success(__('The content has been deleted.'));
        } else {
            $this->Flash->error(__('The content could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Draft method
     *
     * @param int $id Content id.
     * @return \Cake\Http\Response|null|void Redirects to existing or newly-created Content draft.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function draft(?int $id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $draftId = $this->Content->checkForDraft($id);

        if ($draftId > 0) {
            $this->Flash->success('This report has an existing draft below.');

            return $this->redirect(['action' => 'edit', $draftId]);
        }

        $newDraft = $this->Content->copy($id);

        return $this->redirect(['action' => 'edit', $newDraft->id]);
    }

    /** DO WE NEED A PUBLISH CONTROLLER ACTION - ONLY PUBLISH BY CRON JOB/SCRIPT? **/
    /**
     * Publish method
     *
     * @param int $id Content draft id.
     * @return \Cake\Http\Response|null|void Redirects to existing or newly-created Content draft.
     */
    public function publish(int $id)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->Flash->success('Republish successful!');

        return $this->redirect(['action' => 'edit', 1]);
    }
}
