<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TagWikis Controller
 *
 * @property \App\Model\Table\TagWikisTable $TagWikis
 * @method \App\Model\Entity\TagWiki[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagWikisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Wikis', 'Tags'],
        ];
        $tagWikis = $this->paginate($this->TagWikis);

        $this->set(compact('tagWikis'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag Wiki id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tagWiki = $this->TagWikis->get($id, [
            'contain' => ['Wikis', 'Tags'],
        ]);

        $this->set(compact('tagWiki'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tagWiki = $this->TagWikis->newEmptyEntity();
        if ($this->request->is('post')) {
            $tagWiki = $this->TagWikis->patchEntity($tagWiki, $this->request->getData());
            if ($this->TagWikis->save($tagWiki)) {
                $this->Flash->success(__('The tag wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag wiki could not be saved. Please, try again.'));
        }
        $wikis = $this->TagWikis->Wikis->find('list', ['limit' => 200])->all();
        $tags = $this->TagWikis->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('tagWiki', 'wikis', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag Wiki id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tagWiki = $this->TagWikis->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tagWiki = $this->TagWikis->patchEntity($tagWiki, $this->request->getData());
            if ($this->TagWikis->save($tagWiki)) {
                $this->Flash->success(__('The tag wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag wiki could not be saved. Please, try again.'));
        }
        $wikis = $this->TagWikis->Wikis->find('list', ['limit' => 200])->all();
        $tags = $this->TagWikis->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('tagWiki', 'wikis', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag Wiki id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tagWiki = $this->TagWikis->get($id);
        if ($this->TagWikis->delete($tagWiki)) {
            $this->Flash->success(__('The tag wiki has been deleted.'));
        } else {
            $this->Flash->error(__('The tag wiki could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
