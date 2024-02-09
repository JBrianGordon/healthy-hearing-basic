<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * SeoCanonicals Controller
 *
 * @property \App\Model\Table\SeoCanonicalsTable $SeoCanonicals
 * @method \App\Model\Entity\SeoCanonical[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoCanonicalsController extends BaseAdminController
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
        $seoCanonicals = $this->paginate($this->SeoCanonicals);

        $this->set(compact('seoCanonicals'));
    }

    /**
     * View method
     *
     * @param string|null $id Seo Canonical id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoCanonical = $this->SeoCanonicals->get($id, [
            'contain' => ['SeoUris'],
        ]);

        $this->set(compact('seoCanonical'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoCanonical = $this->SeoCanonicals->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoCanonical = $this->SeoCanonicals->patchEntity($seoCanonical, $this->request->getData());
            if ($this->SeoCanonicals->save($seoCanonical)) {
                $this->Flash->success(__('The seo canonical has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo canonical could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoCanonicals->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoCanonical', 'seoUris'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Canonical id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoCanonical = $this->SeoCanonicals->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoCanonical = $this->SeoCanonicals->patchEntity($seoCanonical, $this->request->getData());
            if ($this->SeoCanonicals->save($seoCanonical)) {
                $this->Flash->success(__('The seo canonical has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo canonical could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoCanonicals->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoCanonical', 'seoUris'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Canonical id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoCanonical = $this->SeoCanonicals->get($id);
        if ($this->SeoCanonicals->delete($seoCanonical)) {
            $this->Flash->success(__('The seo canonical has been deleted.'));
        } else {
            $this->Flash->error(__('The seo canonical could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
