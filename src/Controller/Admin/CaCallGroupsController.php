<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\CaCallGroup;

/**
 * CaCallGroups Controller
 *
 * @property \App\Model\Table\CaCallGroupsTable $CaCallGroups
 * @method \App\Model\Entity\CaCallGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CaCallGroupsController extends AppController
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
        $caCallGroup = $this->CaCallGroups->get($id, [
            'contain' => ['Locations', 'CaCalls', 'CaCallGroupNotes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $caCallGroup = $this->CaCallGroups->patchEntity($caCallGroup, $this->request->getData());
            if ($this->CaCallGroups->save($caCallGroup)) {
                $this->Flash->success(__('The ca call group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ca call group could not be saved. Please, try again.'));
        }
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
        $this->autoRender = false;
        $this->Export->exportCsv('export_call_groups.csv');
        die();
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
    }
}
