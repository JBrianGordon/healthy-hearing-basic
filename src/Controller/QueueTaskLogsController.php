<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * QueueTaskLogs Controller
 *
 * @property \App\Model\Table\QueueTaskLogsTable $QueueTaskLogs
 * @method \App\Model\Entity\QueueTaskLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QueueTaskLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $queueTaskLogs = $this->paginate($this->QueueTaskLogs);

        $this->set(compact('queueTaskLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Queue Task Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $queueTaskLog = $this->QueueTaskLogs->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('queueTaskLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $queueTaskLog = $this->QueueTaskLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $queueTaskLog = $this->QueueTaskLogs->patchEntity($queueTaskLog, $this->request->getData());
            if ($this->QueueTaskLogs->save($queueTaskLog)) {
                $this->Flash->success(__('The queue task log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue task log could not be saved. Please, try again.'));
        }
        $users = $this->QueueTaskLogs->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('queueTaskLog', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Queue Task Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $queueTaskLog = $this->QueueTaskLogs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $queueTaskLog = $this->QueueTaskLogs->patchEntity($queueTaskLog, $this->request->getData());
            if ($this->QueueTaskLogs->save($queueTaskLog)) {
                $this->Flash->success(__('The queue task log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue task log could not be saved. Please, try again.'));
        }
        $users = $this->QueueTaskLogs->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('queueTaskLog', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Queue Task Log id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $queueTaskLog = $this->QueueTaskLogs->get($id);
        if ($this->QueueTaskLogs->delete($queueTaskLog)) {
            $this->Flash->success(__('The queue task log has been deleted.'));
        } else {
            $this->Flash->error(__('The queue task log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
