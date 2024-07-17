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
        $query = $this->SeoStatusCodes
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['SeoUris']);

        $seoStatusCodes = $this->paginate($query);

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

        $seoUri = $this->SeoStatusCodes->SeoUris->newEmptyEntity();
        $seoUri = $this->SeoStatusCodes->SeoUris->patchEntity($seoUri, $this->request->getData());

        $seoStatusCode->seo_uri = $seoUri;

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
            'contain' => ['SeoUris'],
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
