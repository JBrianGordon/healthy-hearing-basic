<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * IcingVersions Controller
 *
 * @property \App\Model\Table\IcingVersionsTable $IcingVersions
 * @method \App\Model\Entity\IcingVersion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IcingVersionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Models', 'Users'],
        ];
        $icingVersions = $this->paginate($this->IcingVersions);

        $this->set(compact('icingVersions'));
    }

    /**
     * View method
     *
     * @param string|null $id Icing Version id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $icingVersion = $this->IcingVersions->get($id, [
            'contain' => ['Models', 'Users'],
        ]);

        $this->set(compact('icingVersion'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $icingVersion = $this->IcingVersions->newEmptyEntity();
        if ($this->request->is('post')) {
            $icingVersion = $this->IcingVersions->patchEntity($icingVersion, $this->request->getData());
            if ($this->IcingVersions->save($icingVersion)) {
                $this->Flash->success(__('The icing version has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The icing version could not be saved. Please, try again.'));
        }
        $models = $this->IcingVersions->Models->find('list', ['limit' => 200])->all();
        $users = $this->IcingVersions->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('icingVersion', 'models', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Icing Version id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $icingVersion = $this->IcingVersions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $icingVersion = $this->IcingVersions->patchEntity($icingVersion, $this->request->getData());
            if ($this->IcingVersions->save($icingVersion)) {
                $this->Flash->success(__('The icing version has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The icing version could not be saved. Please, try again.'));
        }
        $models = $this->IcingVersions->Models->find('list', ['limit' => 200])->all();
        $users = $this->IcingVersions->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('icingVersion', 'models', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Icing Version id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $icingVersion = $this->IcingVersions->get($id);
        if ($this->IcingVersions->delete($icingVersion)) {
            $this->Flash->success(__('The icing version has been deleted.'));
        } else {
            $this->Flash->error(__('The icing version could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
