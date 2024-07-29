<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * SeoRedirects Controller
 *
 * @property \App\Model\Table\SeoRedirectsTable $SeoRedirects
 * @method \App\Model\Entity\SeoRedirect[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoRedirectsController extends BaseAdminController
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
        $query = $this->SeoRedirects
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['SeoUris']);

        $seoRedirects = $this->paginate($query);

        $this->set('title', 'SEO Redirects');
        $this->set(compact('seoRedirects'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoRedirect = $this->SeoRedirects->newEmptyEntity();

        $seoUri = $this->SeoRedirects->SeoUris->newEmptyEntity();
        $seoUri = $this->SeoRedirects->SeoUris->patchEntity($seoUri, $this->request->getData());

        $seoRedirect->seo_uri = $seoUri;

        if ($this->request->is('post')) {
            $seoRedirect = $this->SeoRedirects->patchEntity($seoRedirect, $this->request->getData());
            if ($this->SeoRedirects->save($seoRedirect)) {
                $this->Flash->success(__('The seo redirect has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo redirect could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoRedirects->SeoUris->find('list', ['limit' => 200])->all();
        $this->set('title', 'Add SEO Redirect');
        $this->set(compact('seoRedirect', 'seoUris'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Redirect id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoRedirect = $this->SeoRedirects->get($id, [
            'contain' => ['SeoUris'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoRedirect = $this->SeoRedirects->patchEntity($seoRedirect, $this->request->getData());
            if ($this->SeoRedirects->save($seoRedirect)) {
                $this->Flash->success(__('The seo redirect has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo redirect could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoRedirects->SeoUris->find('list', ['limit' => 200])->all();
        $this->set('title', 'Edit SEO Redirect');
        $this->set(compact('seoRedirect', 'seoUris'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Redirect id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoRedirect = $this->SeoRedirects->get($id);
        if ($this->SeoRedirects->delete($seoRedirect)) {
            $this->Flash->success(__('The seo redirect has been deleted.'));
        } else {
            $this->Flash->error(__('The seo redirect could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
