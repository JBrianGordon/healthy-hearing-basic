<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ImportDiffs Controller
 *
 * @property \App\Model\Table\ImportDiffsTable $ImportDiffs
 * @method \App\Model\Entity\ImportDiff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportDiffsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Imports'],
        ];
        $importDiffs = $this->paginate($this->ImportDiffs);

        $this->set(compact('importDiffs'));
    }

    /**
     * View method
     *
     * @param string|null $id Import Diff id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $importDiff = $this->ImportDiffs->get($id, [
            'contain' => ['Imports'],
        ]);

        $this->set(compact('importDiff'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $importDiff = $this->ImportDiffs->newEmptyEntity();
        if ($this->request->is('post')) {
            $importDiff = $this->ImportDiffs->patchEntity($importDiff, $this->request->getData());
            if ($this->ImportDiffs->save($importDiff)) {
                $this->Flash->success(__('The import diff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import diff could not be saved. Please, try again.'));
        }
        $imports = $this->ImportDiffs->Imports->find('list', ['limit' => 200])->all();
        $this->set(compact('importDiff', 'imports'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Import Diff id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $importDiff = $this->ImportDiffs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $importDiff = $this->ImportDiffs->patchEntity($importDiff, $this->request->getData());
            if ($this->ImportDiffs->save($importDiff)) {
                $this->Flash->success(__('The import diff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The import diff could not be saved. Please, try again.'));
        }
        $imports = $this->ImportDiffs->Imports->find('list', ['limit' => 200])->all();
        $this->set(compact('importDiff', 'imports'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Import Diff id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $importDiff = $this->ImportDiffs->get($id);
        if ($this->ImportDiffs->delete($importDiff)) {
            $this->Flash->success(__('The import diff has been deleted.'));
        } else {
            $this->Flash->error(__('The import diff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
