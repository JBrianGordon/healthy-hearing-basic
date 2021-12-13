<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContentLocations Controller
 *
 * @property \App\Model\Table\ContentLocationsTable $ContentLocations
 * @method \App\Model\Entity\ContentLocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentLocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contents', 'Locations', 'Content'],
        ];
        $contentLocations = $this->paginate($this->ContentLocations);

        $this->set(compact('contentLocations'));
    }

    /**
     * View method
     *
     * @param string|null $id Content Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contentLocation = $this->ContentLocations->get($id, [
            'contain' => ['Contents', 'Locations', 'Content'],
        ]);

        $this->set(compact('contentLocation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentLocation = $this->ContentLocations->newEmptyEntity();
        if ($this->request->is('post')) {
            $contentLocation = $this->ContentLocations->patchEntity($contentLocation, $this->request->getData());
            if ($this->ContentLocations->save($contentLocation)) {
                $this->Flash->success(__('The content location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content location could not be saved. Please, try again.'));
        }
        $contents = $this->ContentLocations->Contents->find('list', ['limit' => 200])->all();
        $locations = $this->ContentLocations->Locations->find('list', ['limit' => 200])->all();
        $content = $this->ContentLocations->Content->find('list', ['limit' => 200])->all();
        $this->set(compact('contentLocation', 'contents', 'locations', 'content'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentLocation = $this->ContentLocations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentLocation = $this->ContentLocations->patchEntity($contentLocation, $this->request->getData());
            if ($this->ContentLocations->save($contentLocation)) {
                $this->Flash->success(__('The content location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content location could not be saved. Please, try again.'));
        }
        $contents = $this->ContentLocations->Contents->find('list', ['limit' => 200])->all();
        $locations = $this->ContentLocations->Locations->find('list', ['limit' => 200])->all();
        $content = $this->ContentLocations->Content->find('list', ['limit' => 200])->all();
        $this->set(compact('contentLocation', 'contents', 'locations', 'content'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content Location id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contentLocation = $this->ContentLocations->get($id);
        if ($this->ContentLocations->delete($contentLocation)) {
            $this->Flash->success(__('The content location has been deleted.'));
        } else {
            $this->Flash->error(__('The content location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
