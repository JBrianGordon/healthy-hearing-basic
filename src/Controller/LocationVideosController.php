<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationVideos Controller
 *
 * @property \App\Model\Table\LocationVideosTable $LocationVideos
 * @method \App\Model\Entity\LocationVideo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationVideosController extends AppController
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
        $locationVideos = $this->paginate($this->LocationVideos);

        $this->set(compact('locationVideos'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Video id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationVideo = $this->LocationVideos->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationVideo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationVideo = $this->LocationVideos->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationVideo = $this->LocationVideos->patchEntity($locationVideo, $this->request->getData());
            if ($this->LocationVideos->save($locationVideo)) {
                $this->Flash->success(__('The location video has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location video could not be saved. Please, try again.'));
        }
        $locations = $this->LocationVideos->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationVideo', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Video id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationVideo = $this->LocationVideos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationVideo = $this->LocationVideos->patchEntity($locationVideo, $this->request->getData());
            if ($this->LocationVideos->save($locationVideo)) {
                $this->Flash->success(__('The location video has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location video could not be saved. Please, try again.'));
        }
        $locations = $this->LocationVideos->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationVideo', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Video id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationVideo = $this->LocationVideos->get($id);
        if ($this->LocationVideos->delete($locationVideo)) {
            $this->Flash->success(__('The location video has been deleted.'));
        } else {
            $this->Flash->error(__('The location video could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
