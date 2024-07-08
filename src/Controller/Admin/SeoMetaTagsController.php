<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * SeoMetaTags Controller
 *
 * @property \App\Model\Table\SeoMetaTagsTable $SeoMetaTags
 * @method \App\Model\Entity\SeoMetaTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoMetaTagsController extends BaseAdminController
{
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SeoMetaTags
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['SeoUris']);

        $seoMetaTags = $this->paginate($query);

        $this->set(compact('seoMetaTags'));
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
