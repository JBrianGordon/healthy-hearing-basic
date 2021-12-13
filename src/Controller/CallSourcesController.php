<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CallSources Controller
 *
 * @property \App\Model\Table\CallSourcesTable $CallSources
 * @method \App\Model\Entity\CallSource[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CallSourcesController extends AppController
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
        $callSources = $this->paginate($this->CallSources);

        $this->set(compact('callSources'));
    }

    /**
     * View method
     *
     * @param string|null $id Call Source id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $callSource = $this->CallSources->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('callSource'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $callSource = $this->CallSources->newEmptyEntity();
        if ($this->request->is('post')) {
            $callSource = $this->CallSources->patchEntity($callSource, $this->request->getData());
            if ($this->CallSources->save($callSource)) {
                $this->Flash->success(__('The call source has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The call source could not be saved. Please, try again.'));
        }
        $locations = $this->CallSources->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('callSource', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Call Source id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $callSource = $this->CallSources->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $callSource = $this->CallSources->patchEntity($callSource, $this->request->getData());
            if ($this->CallSources->save($callSource)) {
                $this->Flash->success(__('The call source has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The call source could not be saved. Please, try again.'));
        }
        $locations = $this->CallSources->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('callSource', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Call Source id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $callSource = $this->CallSources->get($id);
        if ($this->CallSources->delete($callSource)) {
            $this->Flash->success(__('The call source has been deleted.'));
        } else {
            $this->Flash->error(__('The call source could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
