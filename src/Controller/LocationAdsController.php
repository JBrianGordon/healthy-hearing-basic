<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationAds Controller
 *
 * @property \App\Model\Table\LocationAdsTable $LocationAds
 * @method \App\Model\Entity\LocationAd[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationAdsController extends AppController
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
        $locationAds = $this->paginate($this->LocationAds);

        $this->set(compact('locationAds'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Ad id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationAd = $this->LocationAds->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationAd'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationAd = $this->LocationAds->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationAd = $this->LocationAds->patchEntity($locationAd, $this->request->getData());
            if ($this->LocationAds->save($locationAd)) {
                $this->Flash->success(__('The location ad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location ad could not be saved. Please, try again.'));
        }
        $locations = $this->LocationAds->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationAd', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Ad id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationAd = $this->LocationAds->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationAd = $this->LocationAds->patchEntity($locationAd, $this->request->getData());
            if ($this->LocationAds->save($locationAd)) {
                $this->Flash->success(__('The location ad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location ad could not be saved. Please, try again.'));
        }
        $locations = $this->LocationAds->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationAd', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Ad id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationAd = $this->LocationAds->get($id);
        if ($this->LocationAds->delete($locationAd)) {
            $this->Flash->success(__('The location ad has been deleted.'));
        } else {
            $this->Flash->error(__('The location ad could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
