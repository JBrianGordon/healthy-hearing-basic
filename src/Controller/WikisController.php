<?php
declare(strict_types=1);

namespace App\Controller;

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
        $this->paginate = [
            'contain' => ['ConsumerGuides'],
        ];
        $wikis = $this->paginate($this->Wikis);

        $this->set(compact('wikis'));
    }

    /**
     * View method
     *
     * @param string|null $id Wiki id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wiki = $this->Wikis->get($id, [
            'contain' => ['ConsumerGuides', 'Users', 'TagWikis'],
        ]);

        $this->set(compact('wiki'));
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
        $consumerGuides = $this->Wikis->ConsumerGuides->find('list', ['limit' => 200])->all();
        $users = $this->Wikis->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('wiki', 'consumerGuides', 'users'));
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
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wiki = $this->Wikis->patchEntity($wiki, $this->request->getData());
            if ($this->Wikis->save($wiki)) {
                $this->Flash->success(__('The wiki has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wiki could not be saved. Please, try again.'));
        }
        $consumerGuides = $this->Wikis->ConsumerGuides->find('list', ['limit' => 200])->all();
        $users = $this->Wikis->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('wiki', 'consumerGuides', 'users'));
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
}
