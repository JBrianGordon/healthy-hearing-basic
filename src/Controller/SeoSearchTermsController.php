<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SeoSearchTerms Controller
 *
 * @property \App\Model\Table\SeoSearchTermsTable $SeoSearchTerms
 * @method \App\Model\Entity\SeoSearchTerm[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoSearchTermsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $seoSearchTerms = $this->paginate($this->SeoSearchTerms);

        $this->set(compact('seoSearchTerms'));
    }

    /**
     * View method
     *
     * @param string|null $id Seo Search Term id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoSearchTerm = $this->SeoSearchTerms->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('seoSearchTerm'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoSearchTerm = $this->SeoSearchTerms->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoSearchTerm = $this->SeoSearchTerms->patchEntity($seoSearchTerm, $this->request->getData());
            if ($this->SeoSearchTerms->save($seoSearchTerm)) {
                $this->Flash->success(__('The seo search term has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo search term could not be saved. Please, try again.'));
        }
        $this->set(compact('seoSearchTerm'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Search Term id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoSearchTerm = $this->SeoSearchTerms->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoSearchTerm = $this->SeoSearchTerms->patchEntity($seoSearchTerm, $this->request->getData());
            if ($this->SeoSearchTerms->save($seoSearchTerm)) {
                $this->Flash->success(__('The seo search term has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo search term could not be saved. Please, try again.'));
        }
        $this->set(compact('seoSearchTerm'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Search Term id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoSearchTerm = $this->SeoSearchTerms->get($id);
        if ($this->SeoSearchTerms->delete($seoSearchTerm)) {
            $this->Flash->success(__('The seo search term has been deleted.'));
        } else {
            $this->Flash->error(__('The seo search term could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
