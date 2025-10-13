<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * SeoUrls Controller
 *
 * @property \App\Model\Table\SeoUrlsTable $SeoUrls
 * @method \App\Model\Entity\SeoUrl[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoUrlsController extends BaseAdminController
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

        $this->loadComponent('PersistQueries', [
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
        $requestParams = $this->request->getQueryParams();

        $seoUrlQuery = $this->SeoUrls
            ->find('search', [
                'search' => $requestParams,
            ]);

        $seoUrls = $this->paginate($seoUrlQuery);

        $this->set('title', 'SEO URLs');
        $this->set(compact('seoUrls'));
        $fields = $this->SeoUrls->getSchema()->typeMap();
        unset($fields['id']);
        unset($fields['seo_uri_i_d']);
        $this->set('fields', $fields);
        // $this->set('fields', $this->SeoUrls->getSchema()->typeMap());
    }

    /**
     * View method
     *
     * @param string|null $id Seo Url id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoUrl = $this->SeoUrls->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('seoUrl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoUrl = $this->SeoUrls->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoUrl = $this->SeoUrls->patchEntity($seoUrl, $this->request->getData());
            if ($this->SeoUrls->save($seoUrl)) {
                $this->Flash->success(__('The seo url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo url could not be saved. Please, try again.'));
        }
        $this->set(compact('seoUrl'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Url id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoUrl = $this->SeoUrls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoUrl = $this->SeoUrls->patchEntity($seoUrl, $this->request->getData());
            if ($this->SeoUrls->save($seoUrl)) {
                $this->Flash->success(__('The seo url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo url could not be saved. Please, try again.'));
        }
        $this->set(compact('seoUrl'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Url id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoUrl = $this->SeoUrls->get($id);
        if ($this->SeoUrls->delete($seoUrl)) {
            $this->Flash->success(__('The seo url has been deleted.'));
        } else {
            $this->Flash->error(__('The seo url could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
