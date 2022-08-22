<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;

/**
 * CaCalls Controller
 *
 * @property \App\Model\Table\CaCallsTable $CaCalls
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallsController extends AppController
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

        $this->loadComponent('Export', [
            'actions' => ['export']
        ]);

        $this->paginate = [
            'order' => ['CaCalls.id' => 'DESC']
        ];
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
            $this->set('currentModel', 'CaCalls');
        }
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()->where(['model' => 'CaCall'])->toArray();
        $contain = [];
        if (isset($requestParams['CaCallGroups'])) {
            // Only contain CaCallGroups if we are searching by CallGroup data. Page loads slower.
            $contain[] = 'CaCallGroups';
        }
        $caCallsQuery = $this->CaCalls->find('search', [
            'search' => $requestParams,
            'contain' => $contain
        ]);
        $caCalls = $this->paginate($caCallsQuery);
        // Contain data after pagination (containing in query is too slow)
        if ($caCalls->count() > 0) {
            $this->CaCalls->loadInto($caCalls, ['CaCallGroups', 'CaCallGroups.Locations', 'Users']);
        }
        $this->set('caCalls', $caCalls);
        $this->set('crmSearches', $crmSearches);
        $this->set('fields', $this->CaCalls->getSchema()->typeMap());
        $this->set('count', $caCallsQuery->count());
        $this->set('agents', $this->CaCalls->Users->findAgents());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function inbound()
    {
        $caCall = $this->CaCalls->newEmptyEntity();
        if ($this->request->is('post')) {
            $caCall = $this->CaCalls->patchEntity($caCall, $this->request->getData());
            if ($this->CaCalls->save($caCall)) {
                $this->Flash->success(__('The ca call has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call could not be saved. Please, try again.'));
        }
        $caCallGroups = $this->CaCalls->CaCallGroups->find('list', ['limit' => 200])->all();
        $users = $this->CaCalls->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('caCall', 'caCallGroups', 'users'));
    }

    /**
     * New Inbound Call
     *
     * @param string|null $id Ca Call id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $caCall = $this->CaCalls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $caCall = $this->CaCalls->patchEntity($caCall, $this->request->getData());
            if ($this->CaCalls->save($caCall)) {
                $this->Flash->success(__('The ca call has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call could not be saved. Please, try again.'));
        }
        $caCallGroups = $this->CaCalls->CaCallGroups->find('list', ['limit' => 200])->all();
        $users = $this->CaCalls->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('caCall', 'caCallGroups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ca Call id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $caCall = $this->CaCalls->get($id);
        if ($this->CaCalls->delete($caCall)) {
            $this->Flash->success(__('The ca call has been deleted.'));
        } else {
            $this->Flash->error(__('The ca call could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
    * Export a list of calls to CSV
    */
    function export() {
        $this->autoRender = false;
        $requestParams = $this->request->getQueryParams();

        $this->Export->setIgnoreFields(['user_id']);
        $this->Export->setAdditionalFields(['Users.username', 'CaCallGroups.location_id', 'CaCallGroups.caller_first_name', 'CaCallGroups.caller_last_name', 'CaCallGroups.patient_first_name', 'CaCallGroups.patient_last_name', 'CaCallGroups.prospect', 'CaCallGroups.score', 'CaCallGroups.status']);
        $this->Export->setOverwriteLabels(['Users.username' => 'Agent']);
        $this->Export->exportCsv('export_calls.csv');
        die();
    }
}
