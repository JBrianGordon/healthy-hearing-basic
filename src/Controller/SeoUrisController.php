<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SeoUris Controller
 *
 * @property \App\Model\Table\SeoUrisTable $SeoUris
 * @method \App\Model\Entity\SeoUri[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoUrisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $seoUris = $this->paginate($this->SeoUris);

        $this->set(compact('seoUris'));
    }

    /**
     * View method
     *
     * @param string|null $id Seo Uri id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoUri = $this->SeoUris->get($id, [
            'contain' => ['SeoCanonicals', 'SeoMetaTags', 'SeoRedirects', 'SeoStatusCodes', 'SeoTitles'],
        ]);

        $this->set(compact('seoUri'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoUri = $this->SeoUris->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoUri = $this->SeoUris->patchEntity($seoUri, $this->request->getData());
            if ($this->SeoUris->save($seoUri)) {
                $this->Flash->success(__('The seo uri has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo uri could not be saved. Please, try again.'));
        }
        $this->set(compact('seoUri'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Uri id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoUri = $this->SeoUris->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoUri = $this->SeoUris->patchEntity($seoUri, $this->request->getData());
            if ($this->SeoUris->save($seoUri)) {
                $this->Flash->success(__('The seo uri has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo uri could not be saved. Please, try again.'));
        }
        $this->set(compact('seoUri'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Uri id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoUri = $this->SeoUris->get($id);
        if ($this->SeoUris->delete($seoUri)) {
            $this->Flash->success(__('The seo uri has been deleted.'));
        } else {
            $this->Flash->error(__('The seo uri could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
