<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * SeoStatusCodes Controller
 *
 * @property \App\Model\Table\SeoStatusCodesTable $SeoStatusCodes
 * @method \App\Model\Entity\SeoStatusCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoStatusCodesController extends BaseAdminController
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
        $seoStatusCodes = $this->paginate($this->SeoStatusCodes);

        $this->set(compact('seoStatusCodes'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoStatusCode = $this->SeoStatusCodes->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoStatusCode = $this->SeoStatusCodes->patchEntity($seoStatusCode, $this->request->getData());
            if ($this->SeoStatusCodes->save($seoStatusCode)) {
                $this->Flash->success(__('The seo status code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo status code could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoStatusCodes->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoStatusCode', 'seoUris'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Status Code id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoStatusCode = $this->SeoStatusCodes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoStatusCode = $this->SeoStatusCodes->patchEntity($seoStatusCode, $this->request->getData());
            if ($this->SeoStatusCodes->save($seoStatusCode)) {
                $this->Flash->success(__('The seo status code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo status code could not be saved. Please, try again.'));
        }
        $seoUris = $this->SeoStatusCodes->SeoUris->find('list', ['limit' => 200])->all();
        $this->set(compact('seoStatusCode', 'seoUris'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Status Code id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoStatusCode = $this->SeoStatusCodes->get($id);
        if ($this->SeoStatusCodes->delete($seoStatusCode)) {
            $this->Flash->success(__('The seo status code has been deleted.'));
        } else {
            $this->Flash->error(__('The seo status code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
