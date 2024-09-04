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
}
