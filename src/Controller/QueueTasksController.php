<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * QueueTasks Controller
 *
 * @property \App\Model\Table\QueueTasksTable $QueueTasks
 * @method \App\Model\Entity\QueueTask[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QueueTasksController extends AppController
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
        $queueTasks = $this->paginate($this->QueueTasks);

        $this->set(compact('queueTasks'));
    }

    /**
     * View method
     *
     * @param string|null $id Queue Task id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $queueTask = $this->QueueTasks->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('queueTask'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $queueTask = $this->QueueTasks->newEmptyEntity();
        if ($this->request->is('post')) {
            $queueTask = $this->QueueTasks->patchEntity($queueTask, $this->request->getData());
            if ($this->QueueTasks->save($queueTask)) {
                $this->Flash->success(__('The queue task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue task could not be saved. Please, try again.'));
        }
        $users = $this->QueueTasks->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('queueTask', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Queue Task id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $queueTask = $this->QueueTasks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $queueTask = $this->QueueTasks->patchEntity($queueTask, $this->request->getData());
            if ($this->QueueTasks->save($queueTask)) {
                $this->Flash->success(__('The queue task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue task could not be saved. Please, try again.'));
        }
        $users = $this->QueueTasks->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('queueTask', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Queue Task id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $queueTask = $this->QueueTasks->get($id);
        if ($this->QueueTasks->delete($queueTask)) {
            $this->Flash->success(__('The queue task has been deleted.'));
        } else {
            $this->Flash->error(__('The queue task could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
