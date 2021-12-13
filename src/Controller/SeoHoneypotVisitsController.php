<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SeoHoneypotVisits Controller
 *
 * @property \App\Model\Table\SeoHoneypotVisitsTable $SeoHoneypotVisits
 * @method \App\Model\Entity\SeoHoneypotVisit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoHoneypotVisitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $seoHoneypotVisits = $this->paginate($this->SeoHoneypotVisits);

        $this->set(compact('seoHoneypotVisits'));
    }

    /**
     * View method
     *
     * @param string|null $id Seo Honeypot Visit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoHoneypotVisit = $this->SeoHoneypotVisits->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('seoHoneypotVisit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoHoneypotVisit = $this->SeoHoneypotVisits->newEmptyEntity();
        if ($this->request->is('post')) {
            $seoHoneypotVisit = $this->SeoHoneypotVisits->patchEntity($seoHoneypotVisit, $this->request->getData());
            if ($this->SeoHoneypotVisits->save($seoHoneypotVisit)) {
                $this->Flash->success(__('The seo honeypot visit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo honeypot visit could not be saved. Please, try again.'));
        }
        $this->set(compact('seoHoneypotVisit'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Honeypot Visit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoHoneypotVisit = $this->SeoHoneypotVisits->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoHoneypotVisit = $this->SeoHoneypotVisits->patchEntity($seoHoneypotVisit, $this->request->getData());
            if ($this->SeoHoneypotVisits->save($seoHoneypotVisit)) {
                $this->Flash->success(__('The seo honeypot visit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo honeypot visit could not be saved. Please, try again.'));
        }
        $this->set(compact('seoHoneypotVisit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Honeypot Visit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoHoneypotVisit = $this->SeoHoneypotVisits->get($id);
        if ($this->SeoHoneypotVisits->delete($seoHoneypotVisit)) {
            $this->Flash->success(__('The seo honeypot visit has been deleted.'));
        } else {
            $this->Flash->error(__('The seo honeypot visit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
