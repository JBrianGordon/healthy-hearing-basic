<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CsCalls Controller
 *
 * @property \App\Model\Table\CsCallsTable $CsCalls
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CsCallsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Calls', 'Locations'],
        ];
        $csCalls = $this->paginate($this->CsCalls);

        $this->set(compact('csCalls'));
    }

    /**
     * View method
     *
     * @param string|null $id Cs Call id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $csCall = $this->CsCalls->get($id, [
            'contain' => ['Calls', 'Locations'],
        ]);

        $this->set(compact('csCall'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $csCall = $this->CsCalls->newEmptyEntity();
        if ($this->request->is('post')) {
            $csCall = $this->CsCalls->patchEntity($csCall, $this->request->getData());
            if ($this->CsCalls->save($csCall)) {
                $this->Flash->success(__('The cs call has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cs call could not be saved. Please, try again.'));
        }
        $calls = $this->CsCalls->Calls->find('list', ['limit' => 200])->all();
        $locations = $this->CsCalls->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('csCall', 'calls', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cs Call id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $csCall = $this->CsCalls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $csCall = $this->CsCalls->patchEntity($csCall, $this->request->getData());
            if ($this->CsCalls->save($csCall)) {
                $this->Flash->success(__('The cs call has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cs call could not be saved. Please, try again.'));
        }
        $calls = $this->CsCalls->Calls->find('list', ['limit' => 200])->all();
        $locations = $this->CsCalls->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('csCall', 'calls', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cs Call id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $csCall = $this->CsCalls->get($id);
        if ($this->CsCalls->delete($csCall)) {
            $this->Flash->success(__('The cs call has been deleted.'));
        } else {
            $this->Flash->error(__('The cs call could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
