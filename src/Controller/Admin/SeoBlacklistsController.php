<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * SeoBlacklists Controller
 *
 * @property \App\Model\Table\SeoBlacklistsTable $SeoBlacklists
 * @method \App\Model\Entity\SeoBlacklist[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoBlacklistsController extends BaseAdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $seoBlacklists = $this->paginate($this->SeoBlacklists);

        $this->set(compact('seoBlacklists'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoBlacklist = $this->SeoBlacklists->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoBlacklist = $this->SeoBlacklists->patchEntity($seoBlacklist, $this->request->getData());
            if ($this->SeoBlacklists->save($seoBlacklist)) {
                $this->Flash->success(__('The seo blacklist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo blacklist could not be saved. Please, try again.'));
        }
        $this->set(compact('seoBlacklist'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Blacklist id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoBlacklist = $this->SeoBlacklists->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoBlacklist = $this->SeoBlacklists->patchEntity($seoBlacklist, $this->request->getData());
            if ($this->SeoBlacklists->save($seoBlacklist)) {
                $this->Flash->success(__('The seo blacklist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo blacklist could not be saved. Please, try again.'));
        }
        $this->set(compact('seoBlacklist'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Blacklist id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoBlacklist = $this->SeoBlacklists->get($id);
        if ($this->SeoBlacklists->delete($seoBlacklist)) {
            $this->Flash->success(__('The seo blacklist has been deleted.'));
        } else {
            $this->Flash->error(__('The seo blacklist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
