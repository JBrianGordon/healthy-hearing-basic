<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ImportStatus Controller
 *
 * @property \App\Model\Table\ImportStatusTable $ImportStatus
 * @method \App\Model\Entity\ImportStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportStatusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations'],
        ];
        $importStatus = $this->paginate($this->ImportStatus);

        $this->set(compact('importStatus'));
    }

    /**
     * View method
     *
     * @param string|null $id Import Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $importStatus = $this->ImportStatus->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('importStatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $importStatus = $this->ImportStatus->newEmptyEntity();
        if ($this->request->is('post')) {
            $importStatus = $this->ImportStatus->patchEntity($importStatus, $this->request->getData());
            if ($this->ImportStatus->save($importStatus)) {
                $this->Flash->success(__('The import status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import status could not be saved. Please, try again.'));
        }
        $locations = $this->ImportStatus->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('importStatus', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Import Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $importStatus = $this->ImportStatus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $importStatus = $this->ImportStatus->patchEntity($importStatus, $this->request->getData());
            if ($this->ImportStatus->save($importStatus)) {
                $this->Flash->success(__('The import status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import status could not be saved. Please, try again.'));
        }
        $locations = $this->ImportStatus->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('importStatus', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Import Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $importStatus = $this->ImportStatus->get($id);
        if ($this->ImportStatus->delete($importStatus)) {
            $this->Flash->success(__('The import status has been deleted.'));
        } else {
            $this->Flash->error(__('The import status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
