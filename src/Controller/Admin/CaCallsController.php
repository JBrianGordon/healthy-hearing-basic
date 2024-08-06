<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;
use Cake\View\JsonView;
use App\Model\Entity\CallSource;
use App\Model\Entity\CaCall;
use App\Model\Entity\CaCallGroup;
use Cake\Utility\Hash;

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

        $this->CaCallGroups = $this->fetchTable('CaCallGroups');
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
        $caCallsQuery = $this->CaCalls->find('search', [
            'search' => $requestParams,
            'contain' => ['CaCallGroups']
        ]);
        $caCalls = $this->paginate($caCallsQuery);
        // Contain data after pagination (containing in query is too slow)
        if ($caCalls->count() > 0) {
            $this->CaCalls->loadInto($caCalls, ['CaCallGroups', 'CaCallGroups.Locations', 'Users']);
        }
        $this->set('title', 'Ca Calls index');
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
            if (empty($requestData['id'])) {
                // Saving a new call
                $requestData['duration'] = strtotime(getCurrentEasternTime()) - strtotime($requestData['start_time']);
            }
            $caCall = $this->CaCalls->patchEntity($caCall, $requestData, ['associated'=>['CaCallGroups']]);
            $validate = ($requestData['ca_call_group']['status'] == CaCallGroup::STATUS_INCOMPLETE) ? false : true;
            if ($validate && $caCall->hasErrors()) {
                $errors = json_encode(Hash::flatten($caCall->getErrors()));
                $this->Flash->error('Failed to save call.<br>'.$errors, ['escape'=>false]);
                return;
            }
            if ($this->CaCalls->save($caCall)) {
                $this->Flash->success('The call has been saved.');
                return $this->redirect('/admin');
            }
            $errors = json_encode(Hash::flatten($caCall->getErrors()));
            $this->Flash->error("The call could not be saved. Please, try again.<br>".$errors, ['escape'=>false]);
        }
        $requestData['start_time'] = getCurrentEasternTime();
        $requestData['call_type'] = CaCall::CALL_TYPE_INBOUND;
        $requestData['user_id'] = $this->user->id;
        $caCall = $this->CaCalls->patchEntity($caCall, $requestData, ['associated'=>['CaCallGroups']]);

        // New inbound call
        $previousCalls = $this->CaCalls->CaCallGroups->getPreviousCalls($locationId, false);
        $this->set('title', 'Edit Call');
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

    /**
    * Finds the specified call group and loads it via ajax.
    */
    public function getCallGroupData($callGroupId = null) {
        $this->viewBuilder()->setLayout('ajax');
        $this->meta['robots'] = "NOINDEX, FOLLOW";
        $caCallGroup = $this->CaCallGroups->get($callGroupId);
        $lockStatus = $this->CaCalls->CaCallGroups->lock($callGroupId, $this->user->id);
        if ($lockStatus) {
            $data = $caCallGroup;
        } else {
            // Failed to lock the call group
            $lockTime = $caCallGroup->lock_time;
            if (date('m/d/Y', strtotime($lockTime)) == date('m/d/Y', strtotime('today'))) {
                $lockTime = 'Today '.date('h:i a', strtotime($lockTime));
            } else {
                $lockTime = date('n/d g:i a', strtotime($lockTime));
            }
            $lockedByUserId = $caCallGroup->id_locked_by_user;
            $lockedBy = ClassRegistry::init('User')->getUserFullName($lockedByUserId);
            $data = [
                'lock_error' => true,
                'lock_time' => $lockTime,
                'locked_by' => $lockedBy
            ];
        }
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', 'data');
        return;
    }

    public function addOutbound($caCallGroupId = null) {
        if (!$caCallGroupId) {
            $this->Flash->error('No Call Group ID given.');
            $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
        }
        if ($this->CaCallGroups->isLocked($caCallGroupId, $this->user->id)) {
            $this->Flash->error('This record is locked.');
            $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
        }

        $requestData = $this->request->getData();
        if (!empty($requestData)) {
            if (empty($this->request->data['CaCallGroup']['id']) && !empty($this->request->data['CaCallGroup']['original_group_id'])) {
                // This was a voicemail call from clinic, but there are no related call groups to handle.
                // Delete this VM call and group.
                $this->CaCall->deleteAll(['CaCall.ca_call_group_id'=>$this->request->data['CaCallGroup']['original_group_id']], false);
                $this->CaCallGroups->delete($this->request->data['CaCallGroup']['original_group_id'], false);
                $this->Flash->success('The call has been saved');
                return $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
            }
            // Saving an outbound call
            $this->request->data['CaCall']['duration'] = strtotime(getCurrentEasternTime()) - strtotime($this->request->data['CaCall']['start_time']);
            $this->CaCall->create();
            $validate = ($this->request->data['CaCallGroup']['status'] == CaCallGroup::STATUS_INCOMPLETE) ? false : true;
            if ($this->CaCall->saveAll($this->request->data, ['validate' => $validate, 'deep' => true])) {
                $this->CaCallGroups->unlock();
                $this->Flash->success(__('The call has been saved'));
                if ($this->request->data['CaCallGroup']['original_group_id'] != $this->request->data['CaCallGroup']['id']) {
                    // This was a voicemail related to a previous call group.
                    // Reassign the VM calls to the new group id. Delete the VM group.
                    $this->CaCall->updateAll(
                        ['CaCall.ca_call_group_id' => $this->request->data['CaCallGroup']['id']],
                        ['CaCall.ca_call_group_id' => $this->request->data['CaCallGroup']['original_group_id']]
                    );
                    $this->CaCallGroups->delete($this->request->data['CaCallGroup']['original_group_id'], false);
                }
                if (($this->request->data['CaCall']['call_type'] == CaCall::CALL_TYPE_FOLLOWUP_NO_ANSWER) &&
                    ($this->request->data['CaCallGroup']['did_they_want_help'] == 1)) {
                    return $this->redirect(array('controller' => 'ca_calls', 'action' => 'copy', $caCallGroupId));
                } else {
                    return $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
                }
            } else {
                $this->Flash->error('The call could not be saved. Please, try again.<br><br>'.print_r($this->CaCall->validationErrors, true));
            }
        } else {
            $caCallGroup = $this->CaCallGroups->get($caCallGroupId, ['contain' => ['CaCallGroupNotes']]);
            $previousCalls = $this->CaCalls->find('all', [
                'conditions' => ['ca_call_group_id' => $caCallGroupId]
            ])->all();
            /*$caCallGroupNotes = $this->CaCallGroupNotes->find('all', [
                'conditions' => ['ca_call_group_id' => $caCallGroupId]
            ])->all();*/
            $caCall = $this->CaCalls->newEntity([
                'ca_call_group_id' => $caCallGroupId,
                'start_time' => getCurrentEasternTime(),
                'user_id' => $this->user->id,
                //'ca_call_group' => $caCallGroup
            ],
            ['associated' => ['CaCallGroups']]);
            $caCall->ca_call_group = $caCallGroup;
            $callType = $this->CaCalls->getCallTypeByStatus($caCallGroup->status, $caCallGroup->score, $caCallGroup->location->direct_book_type, $caCallGroup->wants_hearing_test);
            if (($callType === false) ||
                ($caCallGroup->scheduled_call_date->toUnixString() > strtotime(getCurrentEasternTime()))) {
                // Invalid outbound call
                $this->Flash->error('This call is no longer valid.');
                $this->redirect(['controller' => 'ca_call_groups', 'action' => 'outbound']);
            }
            switch ($caCallGroup->status) {
                case CaCallGroup::STATUS_VM_NEEDS_CALLBACK:
                case CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED:
                    $this->set('recordingUrl', $caCallGroup->ca_calls[0]['recording_url']);
                    $this->set('recordingDuration', $caCallGroup->ca_calls[0]['duration']);
                    $this->set('voicemailTime', $caCallGroup->ca_calls[0]['start_time']);
                    $this->set('voicemailFrom', $caCallGroup->caller_phone);
                    $this->request->data['CaCallGroup']['vm_outbound_count']++;
                    break;
                case CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM:
                case CaCallGroup::STATUS_FOLLOWUP_SET_APPT:
                case CaCallGroup::STATUS_TENTATIVE_APPT:
                    $caCallGroup->clinic_followup_count++;
                    break;
                case CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER:
                    $caCallGroup->patient_followup_count++;
                    break;
                case CaCallGroup::STATUS_APPT_SET:
                case CaCallGroup::STATUS_OUTBOUND_CLINIC_ATTEMPTED:
                    $caCallGroup->clinic_outbound_count++;
                    break;
                case CaCallGroup::STATUS_OUTBOUND_CLINIC_DECLINED:
                case CaCallGroup::STATUS_OUTBOUND_CLINIC_TOO_MANY_ATTEMPTS:
                case CaCallGroup::STATUS_OUTBOUND_CUST_ATTEMPTED:
                    $caCallGroup->patient_outbound_count++;
                    break;
            }
            $caCall->call_type = $callType;
            $this->set('caCall', $caCall);
            $this->set('previousCalls', $previousCalls);
            $this->CaCallGroups->lock($caCallGroupId, $this->user->id);
        }
    }
}
