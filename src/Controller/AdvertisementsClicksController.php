<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AdvertisementsClicks Controller
 *
 * @property \App\Model\Table\AdvertisementsClicksTable $AdvertisementsClicks
 * @method \App\Model\Entity\AdvertisementsClick[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdvertisementsClicksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ads'],
        ];
        $advertisementsClicks = $this->paginate($this->AdvertisementsClicks);

        $this->set(compact('advertisementsClicks'));
    }

    /**
     * View method
     *
     * @param string|null $id Advertisements Click id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $advertisementsClick = $this->AdvertisementsClicks->get($id, [
            'contain' => ['Ads'],
        ]);

        $this->set(compact('advertisementsClick'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $advertisementsClick = $this->AdvertisementsClicks->newEmptyEntity();
        if ($this->request->is('post')) {
            $advertisementsClick = $this->AdvertisementsClicks->patchEntity($advertisementsClick, $this->request->getData());
            if ($this->AdvertisementsClicks->save($advertisementsClick)) {
                $this->Flash->success(__('The advertisements click has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advertisements click could not be saved. Please, try again.'));
        }
        $ads = $this->AdvertisementsClicks->Ads->find('list', ['limit' => 200])->all();
        $this->set(compact('advertisementsClick', 'ads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Advertisements Click id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $advertisementsClick = $this->AdvertisementsClicks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $advertisementsClick = $this->AdvertisementsClicks->patchEntity($advertisementsClick, $this->request->getData());
            if ($this->AdvertisementsClicks->save($advertisementsClick)) {
                $this->Flash->success(__('The advertisements click has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advertisements click could not be saved. Please, try again.'));
        }
        $ads = $this->AdvertisementsClicks->Ads->find('list', ['limit' => 200])->all();
        $this->set(compact('advertisementsClick', 'ads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Advertisements Click id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $advertisementsClick = $this->AdvertisementsClicks->get($id);
        if ($this->AdvertisementsClicks->delete($advertisementsClick)) {
            $this->Flash->success(__('The advertisements click has been deleted.'));
        } else {
            $this->Flash->error(__('The advertisements click could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
