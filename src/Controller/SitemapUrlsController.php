<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SitemapUrls Controller
 *
 * @property \App\Model\Table\SitemapUrlsTable $SitemapUrls
 * @method \App\Model\Entity\SitemapUrl[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SitemapUrlsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $sitemapUrls = $this->paginate($this->SitemapUrls);

        $this->set(compact('sitemapUrls'));
    }

    /**
     * View method
     *
     * @param string|null $id Sitemap Url id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sitemapUrl = $this->SitemapUrls->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('sitemapUrl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sitemapUrl = $this->SitemapUrls->newEmptyEntity();
        if ($this->request->is('post')) {
            $sitemapUrl = $this->SitemapUrls->patchEntity($sitemapUrl, $this->request->getData());
            if ($this->SitemapUrls->save($sitemapUrl)) {
                $this->Flash->success(__('The sitemap url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sitemap url could not be saved. Please, try again.'));
        }
        $this->set(compact('sitemapUrl'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sitemap Url id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sitemapUrl = $this->SitemapUrls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sitemapUrl = $this->SitemapUrls->patchEntity($sitemapUrl, $this->request->getData());
            if ($this->SitemapUrls->save($sitemapUrl)) {
                $this->Flash->success(__('The sitemap url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sitemap url could not be saved. Please, try again.'));
        }
        $this->set(compact('sitemapUrl'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sitemap Url id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sitemapUrl = $this->SitemapUrls->get($id);
        if ($this->SitemapUrls->delete($sitemapUrl)) {
            $this->Flash->success(__('The sitemap url has been deleted.'));
        } else {
            $this->Flash->error(__('The sitemap url could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
