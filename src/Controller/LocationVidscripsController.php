<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationVidscrips Controller
 *
 * @property \App\Model\Table\LocationVidscripsTable $LocationVidscrips
 * @method \App\Model\Entity\LocationVidscrip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationVidscripsController extends AppController
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
        $locationVidscrips = $this->paginate($this->LocationVidscrips);

        $this->set(compact('locationVidscrips'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Vidscrip id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationVidscrip = $this->LocationVidscrips->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationVidscrip'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationVidscrip = $this->LocationVidscrips->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationVidscrip = $this->LocationVidscrips->patchEntity($locationVidscrip, $this->request->getData());
            if ($this->LocationVidscrips->save($locationVidscrip)) {
                $this->Flash->success(__('The location vidscrip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location vidscrip could not be saved. Please, try again.'));
        }
        $locations = $this->LocationVidscrips->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationVidscrip', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Vidscrip id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationVidscrip = $this->LocationVidscrips->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationVidscrip = $this->LocationVidscrips->patchEntity($locationVidscrip, $this->request->getData());
            if ($this->LocationVidscrips->save($locationVidscrip)) {
                $this->Flash->success(__('The location vidscrip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location vidscrip could not be saved. Please, try again.'));
        }
        $locations = $this->LocationVidscrips->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationVidscrip', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Vidscrip id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationVidscrip = $this->LocationVidscrips->get($id);
        if ($this->LocationVidscrips->delete($locationVidscrip)) {
            $this->Flash->success(__('The location vidscrip has been deleted.'));
        } else {
            $this->Flash->error(__('The location vidscrip could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
