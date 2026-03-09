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

        $this->loadComponent('PersistQueries', [
            'actions' => ['index'],
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
        $this->set('title', 'Calls');
        $this->set('caCalls', $caCalls);
        $this->set('crmSearches', $crmSearches);
        $this->set('fields', $this->CaCalls->getSchema()->typeMap());
        $this->set('count', $caCallsQuery->count());
        $this->set('agents', $this->CaCalls->Users->findAgents());
    }

    /**
     * New Inbound Call
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        // New inbound call via Genesys and CallSource JSON integration
        // Genesys will open a URL with the following format:
        // https://www.healthyhearing.com/admin/ca_calls/edit/id:xx/caller_phone:xx
        // Redirect to our new URL format:
        // https://www.healthyhearing.com/admin/ca-calls/edit?id=xx&caller_phone=xx
        // TODO: At some point we should ask the Genesys developers to open the new format
        if ($this->request->getParam('id')) {
            return $this->redirect([
                'action' => 'edit',
                '?' => ['id'=>$this->request->getParam('id'), 'caller_phone'=>$this->request->getParam('caller_phone')]
            ]);
        }
        $locationId = $this->request->getQuery('id');
        $locationId = is_numeric($locationId) ? $locationId : null;
        $callerPhone = $this->request->getQuery('caller_phone');
        if ($locationId == CallSource::LOCATION_ID_FROM_CLINIC) {
            // Return call from clinic
            return $this->redirect([
                'action' => 'clinic_lookup'
            ]);
        } elseif ($locationId == CallSource::LOCATION_ID_QUICK_PICK) {
            // Quick Pick
            return $this->redirect([
                'action' => 'quick_pick',
                '?' => ['caller_phone' => $callerPhone]
            ]);
        }
        $caCall = $this->CaCalls->newEntity([
            'ca_call_group' => [
                'location_id' => $locationId,
                'caller_phone' => $callerPhone,
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
        $count = $this->CaCalls->find('search', [
            'search' => $requestParams,
            'contain' => ['CaCallGroups', 'Users']
        ])->count();
        if ($count < 10000) { // Immediately download small exports
            $this->Export->setIgnoreFields(['user_id']);
            $this->Export->setAdditionalFields(['Users.username', 'CaCallGroups.location_id', 'CaCallGroups.caller_first_name', 'CaCallGroups.caller_last_name', 'CaCallGroups.patient_first_name', 'CaCallGroups.patient_last_name', 'CaCallGroups.prospect', 'CaCallGroups.score', 'CaCallGroups.status']);
            $this->Export->setOverwriteLabels(['Users.username' => 'agent']);
            $this->Export->exportCsv('export_calls.csv');
            return;
        } else {
            $extract = $this->CaCalls->getSchema()->columns();
            $extract = array_merge($extract, ['user.username', 'ca_call_group.location_id', 'ca_call_group.caller_first_name', 'ca_call_group.caller_last_name', 'ca_call_group.patient_first_name', 'ca_call_group.patient_last_name', 'ca_call_group.prospect', 'ca_call_group.score', 'ca_call_group.status']);
            $usersFields = ['Users.username'];
            $callGroupsFields = ['CaCallGroups.location_id', 'CaCallGroups.caller_first_name', 'CaCallGroups.caller_last_name', 'CaCallGroups.patient_first_name', 'CaCallGroups.patient_last_name', 'CaCallGroups.prospect', 'CaCallGroups.score', 'CaCallGroups.status'];
            $containedTables = ['Users' => ['fields' => $usersFields], 'CaCallGroups' => ['fields' => $callGroupsFields]];
            $header = array_map(
                function($item) {
                    return str_replace(['user.', 'ca_call_group.'], '', $item);
                },
                $extract
            );
            $header = str_replace('username', 'agent', $header);
            $caCalls = $this->CaCalls
                ->find('search', [
                    'search' => $this->request->getQueryParams(),
                ]);
            $data = [
                'vars' => [
                    'table' => 'CaCalls',
                    'username' => $this->user->first_name,
                    'queryParams' => $this->request->getQueryParams(),
                    'containedTables' => $containedTables,
                    'extract' => $extract,
                    'header' => $header,
                    'csvExportFile' => '/tmp/export_calls.csv',
                    'to' => $this->user->email
                ],
            ];
            $queuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
            $queuedJobs->createJob('ExportCsv', $data);
            $this->Flash->success('Large file export. Results will be emailed.');
            return $this->redirect(['action' => 'index']);
        }
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
        if (empty($this->user->id)) {
            // catch a user timeout error
            $data = [
                'user_error' => true,
            ];
            $this->set('data', $data);
            $this->viewBuilder()->setOption('serialize', 'data');
            return;
        }
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
            return $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
        }
        if ($this->CaCallGroups->isLocked($caCallGroupId, $this->user->id)) {
            $this->Flash->error('This record is locked.');
            return $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
        }
        $caCallGroup = $this->CaCallGroups->get($caCallGroupId, ['contain' => ['CaCallGroupNotes', 'CaCalls']]);
        $location = $this->CaCallGroups->Locations->get($caCallGroup->location_id);
        $caCall = $this->CaCalls->newEntity([
            'ca_call_group_id' => $caCallGroupId,
            //'start_time' => getCurrentEasternTime(),
            //'user_id' => $this->user->id,
            //'ca_call_group' => $caCallGroup
        ],
        ['associated' => ['CaCallGroups' => ['accessibleFields' => ['id' => true]]]]);
        $caCall->ca_call_group = $caCallGroup;

        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            if (empty($requestData['ca_call_group']['id']) && !empty($requestData['ca_call_group']['original_group_id'])) {
                // This was a voicemail call from clinic, but there are no related call groups to handle.
                // Delete this VM call and group.
                $this->CaCalls->deleteAll(['CaCall.ca_call_group_id'=>$requestData['ca_call_group']['original_group_id']], false);
                $this->CaCallGroups->delete($requestData['ca_call_group']['original_group_id'], false);
                $this->Flash->success('The call has been saved');
                return $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
            }
            // Saving an outbound call
            $requestData['duration'] = strtotime(getCurrentEasternTime()) - strtotime($requestData['start_time']);
            $checkRules = ($requestData['ca_call_group']['status'] == CaCallGroup::STATUS_INCOMPLETE) ? false : true;
            if (!empty($requestData['ca_call_group_id'])) {
                $caCall->ca_call_group_id = $requestData['ca_call_group_id'];
            }
            $caCall = $this->CaCalls->patchEntity($caCall, $requestData, [
                'associated' => ['CaCallGroups' => ['accessibleFields' => ['id' => true]]]
            ]);

            if ($this->CaCalls->save($caCall, ['checkRules' => $checkRules])) {
                $this->CaCallGroups->unlock($caCallGroupId);
                $this->Flash->success(__('The call has been saved'));
                if ($requestData['ca_call_group']['original_group_id'] != $requestData['ca_call_group']['id']) {
                    // This was a voicemail related to a previous call group.
                    // Reassign the VM calls to the new group id. Delete the VM group.
                    $this->CaCalls->updateAll(
                        ['CaCall.ca_call_group_id' => $requestData['ca_call_group']['id']],
                        ['CaCall.ca_call_group_id' => $requestData['ca_call_group']['original_group_id']]
                    );
                    $this->CaCallGroups->delete($requestData['ca_call_group']['original_group_id'], false);
                }
                if (($requestData['call_type'] == CaCall::CALL_TYPE_FOLLOWUP_NO_ANSWER) &&
                    ($requestData['ca_call_group']['did_they_want_help'] == 1)) {
                    //TODO: implement the copy function
                    return $this->redirect(array('controller' => 'ca_calls', 'action' => 'copy', $caCallGroupId));
                } else {
                    return $this->redirect(array('controller' => 'ca_call_groups', 'action' => 'outbound'));
                }
            } else {
                $this->Flash->error('The call could not be saved. Please, try again.<br><br>'.print_r($caCall->getErrors(), true));
            }
        } else {
            $previousCalls = $this->CaCalls->find('all', [
                'conditions' => ['ca_call_group_id' => $caCallGroupId]
            ])->all();
            $caCall = $this->CaCalls->newEntity([
                'ca_call_group_id' => $caCallGroupId,
                'start_time' => getCurrentEasternTime(),
                'user_id' => $this->user->id,
                //'ca_call_group' => $caCallGroup
            ],
            ['associated' => ['CaCallGroups']]);
            $caCall->ca_call_group = $caCallGroup;
            $callType = $this->CaCalls->getCallTypeByStatus($caCallGroup->status, $caCallGroup->score, $location->direct_book_type, $caCallGroup->wants_hearing_test);
            if (($callType === false) ||
                ($caCallGroup->scheduled_call_date->toUnixString() > strtotime(getCurrentEasternTime()))) {
                // Invalid outbound call
                $this->Flash->error('This call is no longer valid.');
                return $this->redirect(['controller' => 'ca_call_groups', 'action' => 'outbound']);
            }
            switch ($caCallGroup->status) {
                case CaCallGroup::STATUS_VM_NEEDS_CALLBACK:
                case CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED:
                    $this->set('recordingUrl', $caCallGroup->ca_calls[0]['recording_url']);
                    $this->set('recordingDuration', $caCallGroup->ca_calls[0]['duration']);
                    $this->set('voicemailTime', $caCallGroup->ca_calls[0]['start_time']);
                    //todo: can this be removed? I don't think it is used
                    //$this->set('voicemailFrom', $caCallGroup->caller_phone);
                    $caCallGroup->vm_outbound_count++;
                    break;
                case CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM:
                case CaCallGroup::STATUS_FOLLOWUP_SET_APPT:
                case CaCallGroup::STATUS_TENTATIVE_APPT:
                    $caCallGroup->clinic_followup_count++;
                    break;
                case CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER:
                    $caCallGroup->patient_followup_count++;
                    break;
            }
            $caCall->call_type = $callType;
            $this->set('caCall', $caCall);
            $this->set('previousCalls', $previousCalls);
            $this->set('title', 'New Outbound Call');
            $this->CaCallGroups->lock($caCallGroupId, $this->user->id);
        }
    }

    public function ajaxConsumerForm($caCallGroupId = null) {
        $this->viewBuilder()->setLayout('ajax');
        $caCallGroup = $this->CaCallGroups->find('all', [
            'contain' => ['Locations','CaCalls','CaCallGroupNotes'],
            'conditions' => ['CaCallGroups.id' => $caCallGroupId],
        ])->first();
        $this->set('recordingUrl', $caCallGroup->ca_calls[0]->recording_url);
        $this->set('recordingDuration', $caCallGroup->ca_calls[0]->duration);
        $this->set('voicemailTime', $caCallGroup->ca_calls[0]->start_time);
        $this->set('voicemailFrom', $caCallGroup->caller_phone);
        $this->set('noteCount', count($caCallGroup->ca_call_group_notes));
//        $this->request->data['CaCallGroup'] = $caCallGroup;
//        $this->request->data['CaCall']['ca_call_group_id'] = $caCallGroupId;
//        $this->request->data['CaCall']['start_time'] = getCurrentEasternTime();
//        $this->request->data['CaCall']['user_id'] = $this->Auth->user('id');
    }

    // Return call from clinic
    public function clinicLookup() {
        if ($this->request->is('post')) {
            if (empty($this->request->data['CaCall']['id'])) {
                // Saving a new call
                $caCall = $this->CaCalls->newEmptyEntity();
                $caCall = $this->CaCalls->patchEntity($caCall, $requestData, [
                    'associated' => ['CaCallGroups']
                ]);
                $caCall->duration = strtotime(getCurrentEasternTime()) - strtotime($caCall->start_time);
            }
            $checkRules = ($caCall->ca_call_group->status == CaCallGroup::STATUS_INCOMPLETE) ? false : true;
            if ($this->CaCalls->save($caCall, ['checkRules' => $checkRules])) {
                $this->Flash->success('The call has been saved');
                return $this->redirect('/admin');
            } else {
                $this->Flash->error('The call could not be saved. Please, try again.<br><br>'.print_r($caCall->getErrors(), true));
            }
        }

        // New followup call
        $caCall = $this->CaCalls->newEmptyEntity();
        $caCall->start_time = getCurrentEasternTime();
        $caCall->user_id = $this->user->id;
        // Call type may be changed by js (followup, tentative, or survey)
        $caCall->call_type = CaCall::CALL_TYPE_FOLLOWUP_APPT;
        $this->set('caCall', $caCall);
    }

    /**
    * New 'Clinic Quick Pick' Call
    *
    * @return void
    */
    public function quickPick() {
        $requestData = $this->request->getData();
        $callerPhone = $this->request->getQuery('caller_phone');
        if ($this->request->is('post')) {
            if (empty($requestData['id'])) {
                // Saving a new call
                $caCall = $this->CaCalls->newEmptyEntity();
            } else {
                $caCall = $this->CaCalls->get($requestData['id']);
            }
            if (!empty($requestData['ca_call_group_id'])) {
                // This call is associeated with an existing call group
                $caCall->ca_call_group = $this->CaCallGroups->get($requestData['ca_call_group_id']);
            }
            $caCall = $this->CaCalls->patchEntity($caCall, $requestData, [
                'associated' => ['CaCallGroups', 'CaCallGroups.CaCallGroupNotes']
            ]);
            $caCall->duration = strtotime(getCurrentEasternTime()) - $caCall->start_time->timestamp;
            $quickPickStatus = $caCall->ca_call_group->status;
            $isIncompleteRefused = in_array( // Is call INCOMPLETE or REFUSED NAME/ADDRESS CALLS?
                $quickPickStatus, [
                    CaCallGroup::STATUS_INCOMPLETE,
                    CaCallGroup::STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS,
                    CaCallGroup::STATUS_QUICK_PICK_CALLER_REFUSED_HELP
                ]
            );
            if ($isIncompleteRefused) { // Remove location_id and set PROSPECT_DISCONNECTED
                $caCall->ca_call_group->location_id = 0;
                $caCall->ca_call_group->prospect = CaCallGroup::PROSPECT_DISCONNECTED;
            }
            if ($quickPickStatus == CaCallGroup::STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS) {
                $caCall->ca_call_group->refused_name = true;
            }
            $caCall->ca_call_group->topic_wants_appt = '1';
            $checkRules = !$isIncompleteRefused; // Only validate calls that are not INCOMPLETE or REFUSED NAME/ADDRESS
            if ($this->CaCalls->save($caCall, ['checkRules' => $checkRules])) {
                $this->Flash->success('The call has been saved');
                return $this->redirect('/admin');
            } else {
                $this->Flash->error('The call could not be saved. Please, try again.<br><br>'.print_r($caCall->getErrors(), true));
            }
        }

        if (empty($caCall)) {
            // New quick-pick call
            $caCall = $this->CaCalls->newEntity([
                'start_time' => getCurrentEasternTime(),
                'call_type' => CaCall::CALL_TYPE_INBOUND_QUICK_PICK,
                'user_id' => $this->user->id,
                'ca_call_group' => [
                    'caller_phone' => $callerPhone,
                    'status' => CaCallGroup::STATUS_INCOMPLETE
                ]
            ]);
        }
        $this->set('previousCalls', []);
        $this->set('caCall', $caCall);
        if (empty($this->user)) {
            $this->Flash->error('Session is expired. Please refresh.');
        }
    }

    /**
    * Finds closest clinics to an originAddress (e.g. customer address)
    * via ajax.
    */
    public function getClosestClinics($originAddress) {
        $this->viewBuilder()->setLayout('ajax');
        $this->meta['robots'] = "NOINDEX, FOLLOW";
        $data = $this->CaCalls->getClosestClinics($originAddress);
        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', 'data');
        return;
    }
}
