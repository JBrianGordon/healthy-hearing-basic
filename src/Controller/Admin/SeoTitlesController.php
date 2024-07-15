<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * SeoTitles Controller
 *
 * @property \App\Model\Table\SeoTitlesTable $SeoTitles
 * @method \App\Model\Entity\SeoTitle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoTitlesController extends BaseAdminController
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
        $query = $this->SeoTitles
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['SeoUris']);

        $seoTitles = $this->paginate($query);

        $this->set(compact('seoTitles'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoTitle = $this->SeoTitles->newEmptyEntity();

        $seoUri = $this->SeoTitles->SeoUris->newEmptyEntity();
        $seoUri = $this->SeoTitles->SeoUris->patchEntity($seoUri, $this->request->getData());

        $seoTitle->seo_uri = $seoUri;
        
        if ($this->request->is('post')) {
            $seoTitle = $this->SeoTitles->patchEntity($seoTitle, $this->request->getData());
            if ($this->SeoTitles->save($seoTitle)) {
                $this->Flash->success(__('The seo title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo title could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoTitles->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoTitle', 'seoUris'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Title id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoTitle = $this->SeoTitles->get($id, [
            'contain' => ['SeoUris'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoTitle = $this->SeoTitles->patchEntity($seoTitle, $this->request->getData());
            if ($this->SeoTitles->save($seoTitle)) {
                $this->Flash->success(__('The seo title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo title could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoTitles->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoTitle', 'seoUris'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Title id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoTitle = $this->SeoTitles->get($id);
        if ($this->SeoTitles->delete($seoTitle)) {
            $this->Flash->success(__('The seo title has been deleted.'));
        } else {
            $this->Flash->error(__('The seo title could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
