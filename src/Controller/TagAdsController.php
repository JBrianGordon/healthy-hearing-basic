<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TagAds Controller
 *
 * @property \App\Model\Table\TagAdsTable $TagAds
 * @method \App\Model\Entity\TagAd[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagAdsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ads', 'Tags'],
        ];
        $tagAds = $this->paginate($this->TagAds);

        $this->set(compact('tagAds'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag Ad id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tagAd = $this->TagAds->get($id, [
            'contain' => ['Ads', 'Tags'],
        ]);

        $this->set(compact('tagAd'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tagAd = $this->TagAds->newEmptyEntity();
        if ($this->request->is('post')) {
            $tagAd = $this->TagAds->patchEntity($tagAd, $this->request->getData());
            if ($this->TagAds->save($tagAd)) {
                $this->Flash->success(__('The tag ad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag ad could not be saved. Please, try again.'));
        }
        $ads = $this->TagAds->Ads->find('list', ['limit' => 200])->all();
        $tags = $this->TagAds->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('tagAd', 'ads', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag Ad id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tagAd = $this->TagAds->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tagAd = $this->TagAds->patchEntity($tagAd, $this->request->getData());
            if ($this->TagAds->save($tagAd)) {
                $this->Flash->success(__('The tag ad has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag ad could not be saved. Please, try again.'));
        }
        $ads = $this->TagAds->Ads->find('list', ['limit' => 200])->all();
        $tags = $this->TagAds->Tags->find('list', ['limit' => 200])->all();
        $this->set(compact('tagAd', 'ads', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag Ad id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tagAd = $this->TagAds->get($id);
        if ($this->TagAds->delete($tagAd)) {
            $this->Flash->success(__('The tag ad has been deleted.'));
        } else {
            $this->Flash->error(__('The tag ad could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
