<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationPhotos Controller
 *
 * @property \App\Model\Table\LocationPhotosTable $LocationPhotos
 * @method \App\Model\Entity\LocationPhoto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationPhotosController extends AppController
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
        $locationPhotos = $this->paginate($this->LocationPhotos);

        $this->set(compact('locationPhotos'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationPhoto = $this->LocationPhotos->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationPhoto'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationPhoto = $this->LocationPhotos->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationPhoto = $this->LocationPhotos->patchEntity($locationPhoto, $this->request->getData());
            if ($this->LocationPhotos->save($locationPhoto)) {
                $this->Flash->success(__('The location photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location photo could not be saved. Please, try again.'));
        }
        $locations = $this->LocationPhotos->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationPhoto', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Photo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationPhoto = $this->LocationPhotos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationPhoto = $this->LocationPhotos->patchEntity($locationPhoto, $this->request->getData());
            if ($this->LocationPhotos->save($locationPhoto)) {
                $this->Flash->success(__('The location photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location photo could not be saved. Please, try again.'));
        }
        $locations = $this->LocationPhotos->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationPhoto', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Photo id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationPhoto = $this->LocationPhotos->get($id);
        if ($this->LocationPhotos->delete($locationPhoto)) {
            $this->Flash->success(__('The location photo has been deleted.'));
        } else {
            $this->Flash->error(__('The location photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
