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
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $csCalls = $this->paginate($this->CsCalls);

        $this->set(compact('csCalls'));
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
