<?php
declare(strict_types=1);

namespace App\Controller\Clinic;
use Cake\Core\Configure;
use Cake\Routing\Router;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\Location;

class CaCallGroupsController extends BaseClinicController
{
    /**
    * Run the clinic report of calls and profile views
    */
    function report($locationId = null)
    {
        // Force recovery email to be filled out
        if (!$this->hasRecoveryEmail()) {
            $this->badFlash('You must first fill out your email to continue. ↓');
            return $this->redirect(['controller' => 'users', 'action' => 'account']);
        }
        $requestData = $this->request->getData();
        if (!$this->isAdmin) {
            // Clinic users are only allowed to see reports for 1 location
            $userLocationId = $this->user->locations[0]->id;
            if ($locationId != $userLocationId) {
                return $this->redirect(['controller' => 'CaCallGroups', 'action' => 'report', $userLocationId]);
            }
            if (empty($locationId)) {
                $this->badFlash('Unable to find call reports for this user. No valid location found.');
                return $this->redirect(['controller' => 'users', 'action' => 'account']);
            }
        } else {
            // Admin user
            $selectedLocationId = $requestData['location_id'] ?? null;
            if (!empty($selectedLocationId)) {
                if ($locationId != $selectedLocationId) {
                    return $this->redirect(['controller' => 'CaCallGroups', 'action' => 'report', $selectedLocationId]);
                }
            }
        }

        /* TODO - SAVE AS PDF NOT WORKING YET
        if ($this->request->getParam('_ext') === 'pdf') {
            /* TODO - SAVE AS PDF NOT WORKING YET
            $this->viewBuilder()->setLayout('pdf');
            // Build request data immutably
            $data = [
                'CaCallGroup' => [
                    'username'   => $locationId,
                    'start_date' => $this->request->getQuery('start'),
                    'end_date'   => $this->request->getQuery('end'),
                ]
            ];
            $this->request = $this->request->withParsedBody($data);
            $isCallTracking = $this->request->getQuery('callTracking');
            $this->set(compact('isCallTracking'));
        }
        */

        //Default grab calls for past year
        if (empty($requestData)) {
            $startDate   = date("m/d/Y", strtotime('-1 year'));
            $endDate     = date("m/d/Y");
        }
        $showProfileViews = false;
        if (!empty($locationId)) {
            $this->Locations = $this->fetchTable('Locations');
            if (!$this->Locations->exists(['id'=>$locationId])) {
                $this->Flash->error('Location '.$locationId.' does not exist');
                return $this->redirect(['action' => 'report']);
            }
            $location = $this->Locations->get($locationId);
            $isCallAssist = $location->is_call_assist;
            $title = $location->title;
            $listingType = $location->listing_type;
            $this->set(compact('isCallAssist','title','listingType'));
        }
        
        if ($this->request->is('post')) {
            $this->CsCalls = $this->fetchTable('CsCalls');
            $startDate = $requestData['start_date'];
            $endDate = $requestData['end_date'];
            if (empty($locationId)) {
                // Admin user will be prompted to enter an oticon id
                $this->render();
                return;
            }

            // Get Call Tracking report (based on CallSource LeadScore data)
            $this->set('csReport', $this->CsCalls->getClinicReport($startDate, $endDate, $locationId));
            $csCalls = $this->CsCalls->find('all', [
                'conditions' => [
                    'start_time >=' => str2datetime($startDate),
                    'start_time <=' => str2datetime($endDate . " 23:59:59"),
                    'location_id' => $locationId
                ],
                'order' => 'start_time DESC'
            ])->all();
            // Get Call Assist report
            $this->set('report', $this->CaCallGroups->getClinicReport($startDate, $endDate, $locationId));
            if ($this->request->getParam('_ext') === 'pdf') {
                $this->set('calls', $this->CaCallGroups->find('all', [
                    'contain' => ['CaCalls'],
                    'conditions' => [
                        'created >=' => str2datetime($startDate),
                        'created <=' => str2datetime($endDate . " 23:59:59"),
                        'location_id' => $locationId,
                        'prospect IN' => [CaCallGroup::PROSPECT_YES, CaCallGroup::PROSPECT_NO]
                    ],
                    'order' => 'CaCallGroups.id DESC'
                ])->all());
            } else {
                $caCallGroupsQuery = $this->CaCallGroups->find('all', [
                    'contain' => ['CaCalls'],
                    'conditions' => [
                        'created >=' => str2datetime($startDate),
                        'created <=' => str2datetime($endDate . " 23:59:59"),
                        'location_id' => $locationId,
                        'prospect IN' => [CaCallGroup::PROSPECT_YES, CaCallGroup::PROSPECT_NO]
                    ]
                ]);
                $this->set('calls', $this->paginate($caCallGroupsQuery));
            }

            //***************************************************************
            // DISABLE PROFILE VIEWS FOR NOW
            // WE MAY ADD THESE BACK IN AT A FUTURE TIME - AFTER CAKE4 LAUNCH
            //***************************************************************
            $showProfileViews = false;
            // Get profile views from Google Analytics
            /*
            $isPremierLocation = $location->listing_type === Location::LISTING_TYPE_PREMIER;
            $showProfileViews = Configure::read('isTieringEnabled') && ($isPremierLocation || $this->isAdmin());
            if ($showProfileViews) {
                // Get profile analytics from Google Analytics Reporting API v4
                $clinicUrl = Router::url($this->Locations->getUrl($locationId));
                // Remove clinic name portion of URL as names can change.
                // URLs with location ID and REGEXP API searches will return results
                // for all matching URLS (e.g. '/hearing-aids/26406-').
                $clinicUrlForAPI = substr($clinicUrl, 0, 20);

                // Get number of pageviews from Google Analytics GA4 API
                $profileViews = $this->GaFourData->find('all', [
                    'conditions' => [
                        'startDate'                 => date("Y-m-d", strtotime($startDate)),
                        'endDate'                   => date("Y-m-d", strtotime($endDate)),
                        'reportingMetric'           => 'screenPageviews',
                        'dimensions'                => ['year', 'month'],
                        'filter'                    => [
                            'dimensionName' => 'pagePath',
                            'filterValue'   => $clinicUrlForAPI,
                        ],
                    ]
                ]);

                $yearAndMonthValues = Hash::extract(
                    $profileViews,
                    'rows.{n}.dimensionValues.{n}.value'
                );
                $yearAndMonthValues = array_chunk($yearAndMonthValues, 2);

                // Join year and month values with '01' (first of month)
                $yearMonthDayValues = array_map(
                    function($input) {
                        return join("-", array_merge($input, ['01']));
                    },
                    $yearAndMonthValues
                );

                $dateLabels = array_map(
                    function ($input) {
                        return date("F Y", strtotime($input));
                    },
                    $yearMonthDayValues
                );

                $monthProfileViews = Hash::extract(
                    $profileViews,
                    'rows.{n}.metricValues.{n}.value'
                );

                // Build array of X-Y time series data
                $profileViewsByMonths = [];
                for ($i=0; $i < count($yearMonthDayValues); $i++) {
                    $profileViewsByMonths[] = [
                        "x" => $yearMonthDayValues[$i],
                        "y" => $monthProfileViews[$i]
                    ];
                }

                // Full clinic URL
                $locationURL = Router::url($this->Locations->getUrl($locationId), true);

                // JSON-ify data
                $profileViewsByMonths = json_encode($profileViewsByMonths);
                $labelsForChart = json_encode($dateLabels);

                $this->set(compact('profileViewsByMonths','labelsForChart','locationURL'));
            }
            */

            $this->set(compact('csCalls'));
        }

        $this->set(compact('startDate', 'endDate', 'locationId', 'showProfileViews'));
    }
}
