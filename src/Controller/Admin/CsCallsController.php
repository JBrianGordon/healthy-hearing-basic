<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * CsCalls Controller
 *
 * @property \App\Model\Table\CsCallsTable $CsCalls
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CsCallsController extends BaseAdminController
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

        $this->loadComponent('PersistQueries', [
            'actions' => ['index'],
        ]);

        $this->loadComponent('Export', [
            'actions' => ['export']
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

        $crmSearches = $this->fetchTable('CrmSearches')
            ->find()
            ->where([
                'model' => 'Content',
            ])->toArray();

        // Call date range
        $callDateRange =
            array_key_exists('start_time_start', $requestParams) &&
            array_key_exists('start_time_end', $requestParams);

        if ($callDateRange) {
            $requestParams['start_time_range'] =
                $requestParams['start_time_start'] . ',' . $requestParams['start_time_end'];
        }

        // Remove fields with default values from search parameters
        foreach ($requestParams as $field => $value) {
            if (urldecode($value) == '(select one)') {
                unset($requestParams[$field]);
            }
        }

        if (array_key_exists('saved_search', $requestParams)) {
            $this->set('savedSearch', true);
        } else {
            $this->set('savedSearch', false);
            $this->set('currentModel', 'CsCalls');
        }

        $query = $this->CsCalls->find('search', ['search' => $requestParams]);
        $this->paginate = [
            'contain' => ['Locations'],
        ];
        $csCalls = $this->paginate($query);
        $this->set('title', 'Call Tracking index');
        $this->set('csCalls', $csCalls);
        $this->set('fields', $this->CsCalls->getSchema()->typeMap());
        $this->set('crmSearches', $crmSearches);
    }

    /**
    * Display the report of Call Tracking Metrics based on call date
    */
    function metrics(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
            $adEndDate = $endDate;
            if (strtotime($adEndDate.' - 12 months') < strtotime('2020-09-15')) {
                // We don't have a full year of averaged data
                $adStartDate = '2020-09-15';
                $d1 = new DateTime($adStartDate);
                $d2 = new DateTime($adEndDate);
                $adMonths = round(date_diff($d1, $d2)->days/30);
            } else {
                $adStartDate = date('Y-m-d', strtotime($adEndDate.' - 12 months'));
                $adMonths = 12;
            }
            $this->set('report', $this->CsCalls->getAdminReport($startDate, $endDate, $adStartDate, $adEndDate));
            $this->set(compact('startDate','endDate','adStartDate','adEndDate','adMonths'));
        }
    }

    /**
    * Export a list of calls to CSV
    */
    function export() {
        $this->autoRender = false;
        $requestParams = $this->request->getQueryParams();
        $count = $this->CsCalls->find('search', [
            'search' => $requestParams,
        ])->count();
        if ($count < 10000) { // Immediately download small exports
            $this->Export->exportCsv('export_tracking_calls.csv');
            return;
        } else {
            $columns = $this->CsCalls->getSchema()->columns();
            $csCalls = $this->CsCalls
                ->find('search', [
                    'search' => $this->request->getQueryParams(),
                ]);
            $data = [
                'vars' => [
                    'table' => 'CsCalls',
                    'username' => $this->user->first_name,
                    'queryParams' => $this->request->getQueryParams(),
                    'extract' => $columns,
                    'header' => $columns,
                    'csvExportFile' => '/tmp/export_tracking_calls.csv',
                    'to' => $this->user->email
                ],
            ];
            $queuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
            $queuedJobs->createJob('ExportCsv', $data);
            $this->Flash->success('Large file export. Results will be emailed.');
            return $this->redirect(['action' => 'index']);
        }
    }
}
