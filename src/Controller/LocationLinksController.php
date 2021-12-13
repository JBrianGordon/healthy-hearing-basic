<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationLinks Controller
 *
 * @property \App\Model\Table\LocationLinksTable $LocationLinks
 * @method \App\Model\Entity\LocationLink[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationLinksController extends AppController
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
        $locationLinks = $this->paginate($this->LocationLinks);

        $this->set(compact('locationLinks'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Link id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationLink = $this->LocationLinks->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationLink'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationLink = $this->LocationLinks->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationLink = $this->LocationLinks->patchEntity($locationLink, $this->request->getData());
            if ($this->LocationLinks->save($locationLink)) {
                $this->Flash->success(__('The location link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location link could not be saved. Please, try again.'));
        }
        $locations = $this->LocationLinks->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationLink', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Link id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationLink = $this->LocationLinks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationLink = $this->LocationLinks->patchEntity($locationLink, $this->request->getData());
            if ($this->LocationLinks->save($locationLink)) {
                $this->Flash->success(__('The location link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location link could not be saved. Please, try again.'));
        }
        $locations = $this->LocationLinks->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationLink', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Link id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationLink = $this->LocationLinks->get($id);
        if ($this->LocationLinks->delete($locationLink)) {
            $this->Flash->success(__('The location link has been deleted.'));
        } else {
            $this->Flash->error(__('The location link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
