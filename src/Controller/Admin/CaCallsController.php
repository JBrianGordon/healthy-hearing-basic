<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;
use Cake\View\JsonView;
use App\Model\Entity\CallSource;
use App\Model\Entity\CaCall;

/**
 * CaCalls Controller
 *
 * @property \App\Model\Table\CaCallsTable $CaCalls
 * @method \App\Model\Entity\CaCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallsController extends BaseAdminController
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

    public function viewClasses(): array
    {
        return [JsonView::class];
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
            ->find()->where(['model' => 'CaCalls'])->toArray();
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
        // New inbound call via CallSource XML integration
        $locationId = $this->request->getQuery('id');
        if ($locationId == CallSource::LOCATION_ID_FROM_CLINIC) {
            // Return call from clinic
            return $this->redirect([
                'action' => 'clinic_lookup'
            ]);
        } elseif ($locationId == CallSource::LOCATION_ID_QUICK_PICK) {
            // Quick Pick
            return $this->redirect([
                'action' => 'quick_pick'
            ]);
        } elseif ($this->CaCalls->CaCallGroups->Locations->get($locationId)) {
            // This is a new inbound call for a valid location id
            return $this->redirect([
                'action' => 'edit',
                '?' => $this->request->getQueryParams()
            ]);
        }
        // else, this is probably an internal call for the agent's direct extension
    }

    /**
     * New Inbound Call
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        $locationId = $this->request->getQuery('id');
        $callerPhone = $this->request->getQuery('caller_phone');
        $xmlFileId = $this->request->getQuery('xml_file_id');
        $caCall = $this->CaCalls->newEntity([
            'ca_call_group' => [
                'location_id' => $locationId,
                'caller_phone' => $callerPhone,
                'id_xml_file' => $xmlFileId
            ]
        ]);
        $requestData = $this->request->getData();
        if ($this->request->is('post')) {
//todo
pr('post data =');
pr($requestData);
die('die post');
            if (empty($requestData->id)) {
                // Saving a new call
                $requestData->duration = strtotime(getCurrentEasternTime()) - strtotime($requestData->start_time);
            }
            $caCall = $this->CaCalls->patchEntity($caCall, $requestData, ['associated'=>['CaCallGroups']]);
            $validate = ($requestData->ca_call_group->status == CaCallGroup::STATUS_INCOMPLETE) ? false : true;
            if ($this->CaCalls->save($caCall)) {
                $this->Flash->success('The call has been saved.');
                return $this->redirect('/admin-panel');
            }
            $this->Flash->error('The call could not be saved. Please, try again.');
        }
        $requestData['start_time'] = getCurrentEasternTime();
        $requestData['call_type'] = CaCall::CALL_TYPE_INBOUND;
        $requestData['user_id'] = $this->user->id;
        $caCall = $this->CaCalls->patchEntity($caCall, $requestData, ['associated'=>['CaCallGroups']]);

        // New inbound call
        $previousCalls = $this->CaCalls->CaCallGroups->getPreviousCalls($locationId, false);
        $this->set('previousCalls', $previousCalls);
        $this->set('caCall', $caCall);
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

    /**
    * Finds info about the specified location and loads it via ajax.
    */
    public function getLocationData($locationId = null) {
        $this->viewBuilder()->setLayout('ajax');
        $this->meta['robots'] = "NOINDEX, FOLLOW";
        $data = $this->CaCalls->getLocationData($locationId);
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', 'data');
        return;
    }

    /**
    * Finds previous calls for the specified location and loads it via ajax.
    */
    public function getPreviousCalls($locationId = null, $followupOnly = false) {
        $this->viewBuilder()->setLayout('ajax');
        $this->meta['robots'] = "NOINDEX, FOLLOW";
        $data = $this->CaCalls->CaCallGroups->getPreviousCalls($locationId, $followupOnly);
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', 'data');
        return;
    }
}
