<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * LocationUsers Controller
 *
 * @property \App\Model\Table\LocationUsersTable $LocationUsers
 * @method \App\Model\Entity\LocationUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationUsersController extends AppController
{
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $requestParams = $this->request->getQueryParams();
        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
            $this->set('currentModel', 'LocationUser');
        }
        $locationUsersQuery = $this->LocationUsers
            ->find('search', [
                'search' => $requestParams,
                'contain' => ['Locations'],
            ]);
        $this->set('locationUsers', $this->paginate($locationUsersQuery));
        $this->set('fields', $this->LocationUsers->getSchema()->typeMap());
    }

    /**
     * Edit method
     *
     * @param string|null $id Location User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationUser = $this->LocationUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationUser = $this->LocationUsers->patchEntity($locationUser, $this->request->getData());
            if ($this->LocationUsers->save($locationUser)) {
                $this->Flash->success(__('The location user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location user could not be saved. Please, try again.'));
        }
        $this->set(compact('locationUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationUser = $this->LocationUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationUser = $this->LocationUsers->patchEntity($locationUser, $this->request->getData());
            if ($this->LocationUsers->save($locationUser)) {
                $this->Flash->success(__('The location user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location user could not be saved. Please, try again.'));
        }
        $this->set(compact('locationUser'));
    }
}
