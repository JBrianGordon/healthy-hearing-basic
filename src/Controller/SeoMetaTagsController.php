<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SeoMetaTags Controller
 *
 * @property \App\Model\Table\SeoMetaTagsTable $SeoMetaTags
 * @method \App\Model\Entity\SeoMetaTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoMetaTagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SeoUris'],
        ];
        $seoMetaTags = $this->paginate($this->SeoMetaTags);

        $this->set(compact('seoMetaTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Seo Meta Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoMetaTag = $this->SeoMetaTags->get($id, [
            'contain' => ['SeoUris'],
        ]);

        $this->set(compact('seoMetaTag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoMetaTag = $this->SeoMetaTags->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoMetaTag = $this->SeoMetaTags->patchEntity($seoMetaTag, $this->request->getData());
            if ($this->SeoMetaTags->save($seoMetaTag)) {
                $this->Flash->success(__('The seo meta tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo meta tag could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoMetaTags->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoMetaTag', 'seoUris'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Meta Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoMetaTag = $this->SeoMetaTags->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoMetaTag = $this->SeoMetaTags->patchEntity($seoMetaTag, $this->request->getData());
            if ($this->SeoMetaTags->save($seoMetaTag)) {
                $this->Flash->success(__('The seo meta tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo meta tag could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoMetaTags->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoMetaTag', 'seoUris'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Meta Tag id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoMetaTag = $this->SeoMetaTags->get($id);
        if ($this->SeoMetaTags->delete($seoMetaTag)) {
            $this->Flash->success(__('The seo meta tag has been deleted.'));
        } else {
            $this->Flash->error(__('The seo meta tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
