<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Zipcodes Controller
 *
 * @property \App\Model\Table\ZipcodesTable $Zipcodes
 * @method \App\Model\Entity\Zipcode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ZipcodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $zipcodes = $this->paginate($this->Zipcodes);

        $this->set(compact('zipcodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Zipcode id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $zipcode = $this->Zipcodes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('zipcode'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $zipcode = $this->Zipcodes->newEmptyEntity();
        if ($this->request->is('post')) {
            $zipcode = $this->Zipcodes->patchEntity($zipcode, $this->request->getData());
            if ($this->Zipcodes->save($zipcode)) {
                $this->Flash->success(__('The zipcode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The zipcode could not be saved. Please, try again.'));
        }
        $this->set(compact('zipcode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Zipcode id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $zipcode = $this->Zipcodes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $zipcode = $this->Zipcodes->patchEntity($zipcode, $this->request->getData());
            if ($this->Zipcodes->save($zipcode)) {
                $this->Flash->success(__('The zipcode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The zipcode could not be saved. Please, try again.'));
        }
        $this->set(compact('zipcode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Zipcode id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $zipcode = $this->Zipcodes->get($id);
        if ($this->Zipcodes->delete($zipcode)) {
            $this->Flash->success(__('The zipcode has been deleted.'));
        } else {
            $this->Flash->error(__('The zipcode could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
