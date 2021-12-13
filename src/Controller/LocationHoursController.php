<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationHours Controller
 *
 * @property \App\Model\Table\LocationHoursTable $LocationHours
 * @method \App\Model\Entity\LocationHour[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationHoursController extends AppController
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
        $locationHours = $this->paginate($this->LocationHours);

        $this->set(compact('locationHours'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Hour id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationHour = $this->LocationHours->get($id, [
            'contain' => ['Locations'],
        ]);

        $this->set(compact('locationHour'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationHour = $this->LocationHours->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationHour = $this->LocationHours->patchEntity($locationHour, $this->request->getData());
            if ($this->LocationHours->save($locationHour)) {
                $this->Flash->success(__('The location hour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location hour could not be saved. Please, try again.'));
        }
        $locations = $this->LocationHours->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationHour', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Hour id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationHour = $this->LocationHours->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationHour = $this->LocationHours->patchEntity($locationHour, $this->request->getData());
            if ($this->LocationHours->save($locationHour)) {
                $this->Flash->success(__('The location hour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location hour could not be saved. Please, try again.'));
        }
        $locations = $this->LocationHours->Locations->find('list', ['limit' => 200])->all();
        $this->set(compact('locationHour', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Hour id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationHour = $this->LocationHours->get($id);
        if ($this->LocationHours->delete($locationHour)) {
            $this->Flash->success(__('The location hour has been deleted.'));
        } else {
            $this->Flash->error(__('The location hour could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
