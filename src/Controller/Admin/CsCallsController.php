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
        $this->set('csCalls', $csCalls);
        $this->set('fields', $this->CsCalls->getSchema()->typeMap());
        $this->set('crmSearches', $crmSearches);
    }

    /**
    * Display the report of Call Tracking Metrics based on call date
    */
    function metrics(){
        //*** TODO: this action likely requires updates ***
        //$this->dataToNamed('CsCall');
        if (empty($this->request->data) && !empty($this->request->params['named'])) {
            $this->request->data['CsCall']['start_date'] = $this->request->params['named']['start_date'];
            $this->request->data['CsCall']['end_date'] = $this->request->params['named']['end_date'];
        }
        if (!empty($this->request->data)) {
            $startDate = $this->request->data['CsCall']['start_date'];
            $endDate = $this->request->data['CsCall']['end_date'];
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
            $this->set('report', $this->CsCall->getAdminReport($startDate, $endDate, $adStartDate, $adEndDate));
            $this->set(compact('startDate','endDate','adStartDate','adEndDate','adMonths'));
        }
    }
}
