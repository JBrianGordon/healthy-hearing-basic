<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\CaCallGroup;
use Cake\I18n\FrozenTime;

/**
 * CaCallGroups Controller
 *
 * @property \App\Model\Table\CaCallGroupsTable $CaCallGroups
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallGroupsController extends BaseAdminController
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
            'limit' => 30,
            'order' => ['CaCallGroups.id' => 'DESC']
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
            $this->set('currentModel', 'CaCallGroups');
        }
        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()->where(['model' => 'CaCallGroups'])->toArray();
        $caCallGroupsQuery = $this->CaCallGroups->find('search', [
            'search' => $requestParams,
            'contain' => ['Locations', 'CaCalls'],
        ]);
        $spamCount = $this->CaCallGroups->find()->where(['is_spam' => true])->count();
        $this->set('title', 'Call Groups');
        $this->set('caCallGroups', $this->paginate($caCallGroupsQuery));
        $this->set('crmSearches', $crmSearches);
        $this->set('fields', $this->CaCallGroups->getSchema()->typeMap());
        $this->set('count', $caCallGroupsQuery->count());
        $this->set('spamCount', $spamCount);
    }

    /**
     * View method
     *
     * @param string|null $id Ca Call Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $caCallGroup = $this->CaCallGroups->get($id, [
            'contain' => ['Locations', 'CaCallGroupNotes', 'CaCalls'],
        ]);

        $this->set(compact('caCallGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ca Call Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $associations = [
            'Locations',
            'CaCalls',
            'CaCallGroupNotes' => [
                'sort' => ['CaCallGroupNotes.created' => 'DESC']
            ],
        ];
        $caCallGroup = $this->CaCallGroups->get($id, [
            'contain' => $associations,
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // remove empty notes
            foreach ($data['ca_call_group_notes'] as $key => $caCallGroupNote) {
                if (empty($caCallGroupNote['body'])) {
                    unset($data['ca_call_group_notes'][$key]);
                }
            }
            $caCallGroup = $this->CaCallGroups->patchEntity(
                $caCallGroup,
                $data,
                ['associated' => $associations]
            );
            if ($this->CaCallGroups->save($caCallGroup)) {
                $this->Flash->success(__('The ca call group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call group could not be saved. Please, try again.'));
        }
        $this->set('title', 'Edit Call Group');
        $this->set(compact('caCallGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ca Call Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $caCallGroup = $this->CaCallGroups->get($id);
        if ($this->CaCallGroups->delete($caCallGroup)) {
            $this->Flash->success(__('The ca call group has been deleted.'));
        } else {
            $this->Flash->error(__('The ca call group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
    * Export a list of call groups to CSV
    */
    function export() {
        $count = $this->CaCallGroups
            ->find('search', [
                'search' => $this->request->getQueryParams(),
            ])->count();
        if ($count < 10000) { // Immediately download small exports
            $this->autoRender = false;
            $this->Export->exportCsv('export_call_groups.csv');
            return;
        } else { // Email large exports
            $columns = $this->CaCallGroups->getSchema()->columns();
            $data = [
                'vars' => [
                    'table' => 'CaCallGroups',
                    'username' => $this->user->first_name,
                    'queryParams' => $this->request->getQueryParams(),
                    'extract' => $columns,
                    'header' => $columns,
                    'csvExportFile' => '/tmp/export_call_groups.csv',
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
     * Outbound calls page
     */
    public function outbound()
    {
        $requestParams = $this->request->getData();
        // Hide outbound calls that are scheduled for more than 1 month ago
        $oneMonthAgo = getDateTime('-1 month', 'GMT', 'Y-m-d H:i:s');
        $now = getDateTime('now', 'GMT', 'Y-m-d H:i:s');
        $defaultStatus = [
            CaCallGroup::STATUS_VM_NEEDS_CALLBACK,
            CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED,
            CaCallGroup::STATUS_FOLLOWUP_SET_APPT,
            CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM,
            CaCallGroup::STATUS_TENTATIVE_APPT,
            CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER,
        ];
        $conditions = [
            'ca_call_count >' => 0,
            'status IN' => $defaultStatus,
            'AND' => [
                'scheduled_call_date >=' => $oneMonthAgo,
                'scheduled_call_date <=' => $now,
            ],
            'is_spam' => false,
        ];
        if (!empty($requestParams['status'])) {
            $status = $requestParams['status'];
            if (str_contains($status, '!')) {
                $status = array_diff($defaultStatus, [str_replace('!', '', $status)]);
                $conditions['status IN'] = $status;
            } elseif (str_contains($requestParams['status'], '[or]')) {
                $conditions['status IN'] = explode('[or]', $requestParams['status']);
            } else {
                $conditions['status IN'] = [$status];
            }
        }
        if (!empty($requestParams['score'])) {
            $conditions['score'] = $requestParams['score'];
        }
        if (!empty($requestParams['is_appt_request_form'])) {
            $conditions['is_appt_request_form'] = true;
        }
        if (!empty($requestParams['tzFilter'])) {
            $timezoneConditions = $this->CaCallGroups->Locations->getTimezoneConditions($requestParams['tzFilter']);
            if (!empty($timezoneConditions)) {
                $conditions['Locations.timezone IN'] = $timezoneConditions;
            }
        }
        $caCallGroupsQuery = $this->CaCallGroups->find('all', [
            'conditions' => $conditions,
            'contain' => ['Locations', 'CaCalls'],
        ]);
        $this->paginate['order'] = [];
        $this->paginate['order'][] = "FIELD(status, '".
            CaCallGroup::STATUS_VM_NEEDS_CALLBACK."', '".
            CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED."', '".
            CaCallGroup::STATUS_FOLLOWUP_NO_ANSWER."', '".
            CaCallGroup::STATUS_FOLLOWUP_SET_APPT."', '".
            CaCallGroup::STATUS_FOLLOWUP_APPT_REQUEST_FORM."', '".
            CaCallGroup::STATUS_TENTATIVE_APPT."')";
        $this->paginate['order'][] = "scheduled_call_date ASC";
        $this->set('caCallGroups', $this->paginate($caCallGroupsQuery));
        $this->set('title', 'Outbound calls');
    }

    /**
    * Unlock a call group and redirect back to Outbound Calls page.
    */
    function unlock($id = null) {
        if (!$id) {
            $this->Flash->error('No ID given.');
        } else {
            if ($this->CaCallGroups->unlock($id)) {
                $this->Flash->success("Cancelled and Unlocked");
            } else {
                $this->Flash->error("Unable to unlock $id");
            }
        }
        $this->redirect(['action' => 'outbound']);
    }

    /**
    * Display the report of Call Concierge Metrics based on initial call date
    */
    function metrics(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
            $this->set('report', $this->CaCallGroups->getAdminReport($startDate, $endDate));
            $this->set(compact('startDate','endDate'));
        }
    }

    /**
    * Display the report of Appt Request Form Metrics based on initial call date
    */
    function requestFormMetrics(){
        $results = null;
        $requestData = $this->request->getData();
        if (!empty($requestData)) {
            $startDate = $requestData['start_date'];
            $endDate = $requestData['end_date'].' 23:59:59';
            $results = [];
            $callGroups = $this->CaCallGroups->find('all', [
                'contain' => ['CaCalls'],
                'conditions' => [
                    'is_appt_request_form' => true,
                    'CaCallGroups.created >=' => $startDate,
                    'CaCallGroups.created <=' => $endDate
                ],
            ])->all();
            $filters = [
                'all' => 'All Appt Request Forms',
                'businessHours' => 'Forms submitted during business hours (8:30am-5pm Eastern)'
            ];
            foreach ($filters as $key => $filter) {
                $total = 0;
                $totalInitTimeDiff = 0;
                $initCallCount = 0;
                $callback1Hour = 0;
                $callbackSameDay = 0;
                $callbackAfter1Day = 0;
                $callbackNever = 0;
                $tentative = 0;
                $completed = 0;
                $totalFinalTimeDiff = 0;
                $totalFollowupCount = 0;
                $completedWithInitialCall = 0;
                $completedWithSubsequentCall = 0;
                $nonProspect = 0;
                $prospect = 0;
                $apptSet = 0;
                $missedOpportunity = 0;
                $disconnect = 0;
                foreach ($callGroups as $callGroup) {
                    // Filter out these groups:
                    if ($key == 'businessHours') {
                        // Filter out groups that started on a weekend or evening
                        $dayOfWeek = $callGroup->ca_calls[0]->start_time->format('D');
                        $hourMinute = $callGroup->ca_calls[0]->start_time->format('Hi');
                        if (in_array($dayOfWeek, ['Sat', 'Sun'])) {
                            continue;
                        }
                        if ($hourMinute < '0830') {
                            continue;
                        }
                        if ($hourMinute > '1700') {
                            continue;
                        }
                    }
                    $total++;
                    if (isset($callGroup->ca_calls[1])) {
                        $initTimeDiff = $callGroup->ca_calls[1]->start_time->toUnixString() - $callGroup->ca_calls[0]->start_time->toUnixString();
                        $totalInitTimeDiff += $initTimeDiff;
                        $initCallCount++;
                        if (($initTimeDiff/3600) <= 1) {
                            $callback1Hour++;
                        } elseif ($callGroup->ca_calls[1]->start_time->format('Y-m-d') === $callGroup->ca_calls[0]->start_time->format('Y-m-d')) {
                            $callbackSameDay++;
                        } else {
                            $callbackAfter1Day++;
                        }
                    } else {
                        $callbackNever++;
                    }
                    if (isset($callGroup->final_score_date)) {
                        $completed++;
                        $finalTimeDiff = $callGroup->final_score_date->toUnixString() - $callGroup->ca_calls[0]->start_time->toUnixString();
                        $totalFinalTimeDiff += $finalTimeDiff;
                        $totalFollowupCount += $callGroup->clinic_followup_count;
                        if ($callGroup->clinic_followup_count == 1) {
                            $completedWithInitialCall++;
                        } else {
                            $completedWithSubsequentCall++;
                        }
                        if ($callGroup->prospect == CaCallGroup::PROSPECT_NO) {
                            $nonProspect++;
                        } elseif ($callGroup->prospect == CaCallGroup::PROSPECT_YES) {
                            $prospect++;
                            if ($callGroup->score == CaCallGroup::SCORE_MISSED_OPPORTUNITY) {
                                $missedOpportunity++;
                            }
                            if ($callGroup->score == CaCallGroup::SCORE_DISCONNECTED) {
                                $disconnect++;
                            }
                            if (in_array($callGroup->score, [CaCallGroup::SCORE_APPT_SET, CaCallGroup::SCORE_APPT_SET_DIRECT])) {
                                $apptSet++;
                            }
                        }
                    }
                    if ($callGroup->score == CaCallGroup::SCORE_TENTATIVE_APPT) {
                        $tentative++;
                    }
                }
                $results[$key]['total'] = $total;
                $results[$key]['averageInitTimeDiff'] = empty($initCallCount) ? 0 : $totalInitTimeDiff / $initCallCount;
                $results[$key]['callback1Hour'] = $callback1Hour;
                $results[$key]['callbackSameDay'] = $callbackSameDay;
                $results[$key]['callbackAfter1Day'] = $callbackAfter1Day;
                $results[$key]['callbackNever'] = $callbackNever;
                $results[$key]['tentative'] = $tentative;
                $results[$key]['completed'] = $completed;
                $results[$key]['averageFinalTimeDiff'] = empty($completed) ? 0 : $totalFinalTimeDiff / $completed;
                $results[$key]['averageCallsUntilComplete'] = empty($completed) ? 0 : $totalFollowupCount / $completed;
                $results[$key]['completedWithInitialCall'] = $completedWithInitialCall;
                $results[$key]['completedWithSubsequentCall'] = $completedWithSubsequentCall;
                $results[$key]['nonProspect'] = $nonProspect;
                $results[$key]['prospect'] = $prospect;
                $results[$key]['missedOpportunity'] = $missedOpportunity;
                $results[$key]['disconnect'] = $disconnect;
                $results[$key]['apptSet'] = $apptSet;
            }
        }
        $this->set(compact('startDate', 'endDate', 'results', 'filters'));
    }

    /**
    * Export a list of appt request forms with callback time info
    */
    function formsExport() {
        $this->response = $this->response->withDownload('export_forms.csv');
        $this->layout = 'csv';
        $startDate = $this->request->getQuery('startDate');
        $endDate = $this->request->getQuery('endDate').' 23:59:59';

        $data = [];
        $_header = [
            'CallGroup ID',
            'Submission date (EST)',
            'Init callback date (EST)',
            'Time until init callback',
            'prospect',
            'score',
            'final score date',
            '# followup calls',
            'Calls until completion',
            'Time until completion'
        ];
        $callGroups = $this->CaCallGroups->find('all', [
            'contain' => ['CaCalls'],
            'conditions' => [
                'is_appt_request_form' => true,
                'AND' => [
                    'CaCallGroups.created >=' => $startDate,
                    'CaCallGroups.created <=' => $endDate,
                ],
            ],
            'order' => 'CaCallGroups.id ASC'
        ])->all();
        foreach ($callGroups as $callGroup) {
            // Filter out groups that started on a weekend or evening
            $dayOfWeek = $callGroup->ca_calls[0]->start_time->format('D');
            $hourMinute = $callGroup->ca_calls[0]->start_time->format('Hi');
            if (in_array($dayOfWeek, ['Sat', 'Sun'])) {
                continue;
            }
            if ($hourMinute < '0830') {
                continue;
            }
            if ($hourMinute > '1700') {
                continue;
            }
            if (isset($callGroup->ca_calls[1])) {
                $initCallbackDate = $callGroup->ca_calls[1]->start_time;
                $initTimeDiff = $callGroup->ca_calls[1]->start_time->toUnixString() - $callGroup->ca_calls[0]->start_time->toUnixString();
                $totalMinutes = round($initTimeDiff/60);
                $hours = floor($initTimeDiff/3600);
                $minutes = $totalMinutes - ($hours * 60);
                $displayInitTimeDiff = $totalMinutes.' minutes';
                $displayInitTimeDiff .= $hours > 0 ? ' ('.$hours.' hours, '.$minutes.' minutes)' : '';
            } else {
                $initCallbackDate = null;
                $displayInitTimeDiff = null;
            }
            if (!empty($callGroup->final_score_date)) {
                $finalScoreDate = $callGroup->final_score_date->format('Y-m-d H:i');
                $callsUntilComplete = $callGroup->clinic_followup_count;
                $finalTimeDiff = $callGroup->final_score_date->toUnixString() - $callGroup->ca_calls[0]->start_time->toUnixString();
                $days =  floor($finalTimeDiff/86400);
                $hours = round(($finalTimeDiff - ($days * 86400))/3600, 1);
                $displayFinalTimeDiff = empty($days) ? '' : $days.' days, ';
                $displayFinalTimeDiff .= $hours.' hours';
            } else {
                $callsUntilComplete = null;
                $displayFinalTimeDiff = null;
                $finalScoreDate = null;
            }
            $data[] = [
                $callGroup->id,
                $callGroup->ca_calls[1]->start_time,
                $initCallbackDate,
                $displayInitTimeDiff,
                $callGroup->prospect,
                $callGroup->score,
                $finalScoreDate,
                $callGroup->clinic_followup_count,
                $callsUntilComplete,
                $displayFinalTimeDiff
            ];
        }
        $_serialize = 'data';
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('data', '_serialize', '_header'));
    }
}
