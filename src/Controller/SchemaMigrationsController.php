<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchemaMigrations Controller
 *
 * @property \App\Model\Table\SchemaMigrationsTable $SchemaMigrations
 * @method \App\Model\Entity\SchemaMigration[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SchemaMigrationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $schemaMigrations = $this->paginate($this->SchemaMigrations);

        $this->set(compact('schemaMigrations'));
    }

    /**
     * View method
     *
     * @param string|null $id Schema Migration id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $schemaMigration = $this->SchemaMigrations->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('schemaMigration'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $schemaMigration = $this->SchemaMigrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $schemaMigration = $this->SchemaMigrations->patchEntity($schemaMigration, $this->request->getData());
            if ($this->SchemaMigrations->save($schemaMigration)) {
                $this->Flash->success(__('The schema migration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The schema migration could not be saved. Please, try again.'));
        }
        $this->set(compact('schemaMigration'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Schema Migration id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $schemaMigration = $this->SchemaMigrations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schemaMigration = $this->SchemaMigrations->patchEntity($schemaMigration, $this->request->getData());
            if ($this->SchemaMigrations->save($schemaMigration)) {
                $this->Flash->success(__('The schema migration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The schema migration could not be saved. Please, try again.'));
        }
        $this->set(compact('schemaMigration'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Schema Migration id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schemaMigration = $this->SchemaMigrations->get($id);
        if ($this->SchemaMigrations->delete($schemaMigration)) {
            $this->Flash->success(__('The schema migration has been deleted.'));
        } else {
            $this->Flash->error(__('The schema migration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
