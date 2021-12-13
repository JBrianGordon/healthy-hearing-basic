<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContentTags Controller
 *
 * @property \App\Model\Table\ContentTagsTable $ContentTags
 * @method \App\Model\Entity\ContentTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentTagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contents', 'Tags', 'Content'],
        ];
        $contentTags = $this->paginate($this->ContentTags);

        $this->set(compact('contentTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Content Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contentTag = $this->ContentTags->get($id, [
            'contain' => ['Contents', 'Tags', 'Content'],
        ]);

        $this->set(compact('contentTag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentTag = $this->ContentTags->newEmptyEntity();
        if ($this->request->is('post')) {
            $contentTag = $this->ContentTags->patchEntity($contentTag, $this->request->getData());
            if ($this->ContentTags->save($contentTag)) {
                $this->Flash->success(__('The content tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content tag could not be saved. Please, try again.'));
        }
        $contents = $this->ContentTags->Contents->find('list', ['limit' => 200])->all();
        $tags = $this->ContentTags->Tags->find('list', ['limit' => 200])->all();
        $content = $this->ContentTags->Content->find('list', ['limit' => 200])->all();
        $this->set(compact('contentTag', 'contents', 'tags', 'content'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentTag = $this->ContentTags->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentTag = $this->ContentTags->patchEntity($contentTag, $this->request->getData());
            if ($this->ContentTags->save($contentTag)) {
                $this->Flash->success(__('The content tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content tag could not be saved. Please, try again.'));
        }
        $contents = $this->ContentTags->Contents->find('list', ['limit' => 200])->all();
        $tags = $this->ContentTags->Tags->find('list', ['limit' => 200])->all();
        $content = $this->ContentTags->Content->find('list', ['limit' => 200])->all();
        $this->set(compact('contentTag', 'contents', 'tags', 'content'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content Tag id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contentTag = $this->ContentTags->get($id);
        if ($this->ContentTags->delete($contentTag)) {
            $this->Flash->success(__('The content tag has been deleted.'));
        } else {
            $this->Flash->error(__('The content tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
