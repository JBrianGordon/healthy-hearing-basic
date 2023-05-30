<?php
declare(strict_types=1);

namespace App\Controller;
use App\Model\Entity\Location;

use App\Enums\Model\Review\ReviewStatus;
use App\Enums\Model\Review\ReviewOrigin;
use Cake\View\JsonView;
use Cake\Log\LogTrait;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Core\Configure;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
{
    // public function viewClasses(): array
    // {
    //     return [JsonView::class];
    // }

    // Main /hearing-aids FAC page ( previously called states() )
    public function viewFac()
    {
        if ($_SERVER['REQUEST_URI'] != Router::url(['controller'=>'locations', 'action'=>'viewFac'])) {
            // Self heal url. Redirect to proper url format.
            return $this->redirect(array('controller'=>'locations', 'action'=>'viewFac'), 301);
        }

        //set up and assign the meta tag info
        $request = env('REQUEST_URI');
        $this->SeoMetaTags = $this->fetchTable('SeoMetaTags');
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
        $this->set('seoMetaTags', $seoMetaTags);

        $this->set('states', Configure::read('states'));
        $this->set('countries', Configure::read('countries'));
        $this->set('cities', $this->fetchTable('Cities')->find('all', [
            'conditions' => [
                'is_featured' => 1
            ],
            'order' => 'city'
        ])->all());
        $this->set('fapterm', $this->fapSearchTerm());
    }

    // State page ( previously called cities() )
    public function viewState($region = null)
    {
        if (!empty($region)) {
            // Format the state correctly and make sure it is valid for this country
            $region = $this->Locations->stateRegion($region);
        }
        if (empty($region)) {
            // An invalid state was passed
            return $this->throw404NotFound();
        }
        if ($region == 'DC-Dist-Of-Columbia') {
            // Skip the state page for DC
            return $this->redirect('/hearing-aids/DC-Dist-Of-Columbia/Washington', 301);
        }
        if ($_SERVER['REQUEST_URI'] != Router::url(['controller'=>'locations','action'=>'viewState','region'=>$region])) {
            // Self heal url. Redirect to proper url format.
            return $this->redirect(['controller'=>'locations','action'=>'viewState','region'=>$region], 301);
        }

        $citiesTable = $this->fetchTable('Cities');
        $countMetricsTable = $this->fetchTable('CountMetrics');
        $state = $this->Locations->parseStateSlug($region);
        $stateNice = $this->Locations->stateFull($state);
        $stateAbbr = $this->Locations->stateAbbr($state);

        $limit = $stateAbbr == 'DC' ? 1 : 5;

        $totalClinics = $countMetricsTable->getCount($stateAbbr, 'clinics', 'state');

        $topCities = $citiesTable->find('all', [
            'conditions' => [
                'state' => $stateAbbr,
                'is_near_location' => true,
            ],
            'order' => [
                'population'=>'DESC'
            ],
            'limit' => $limit
        ])->all();

        $this->set('totalClinics', $totalClinics);
        $this->set('topCities', $topCities);

        // Get state-specific resources
        $stateInfo = $this->fetchTable('States')->find('all', [
            'conditions' => [
                'name' => $stateNice,
                'is_active' => true
            ]
        ])->first();

        if (!empty($stateInfo->body)) {
            $this->set('stateInfo', $stateInfo->body);
        }

        $statePageFields = ['id','title','listing_type','address','address_2','city','state','zip','is_mobile','is_call_assist','direct_book_type','direct_book_iframe','average_rating','reviews_approved'];

        // Get mobile clinics in a state
        $mobileClinicsInState = $this->Locations->find('all', [
            'conditions' => [
                'Locations.state' => $stateAbbr,
                'Locations.is_active' => true,
                'Locations.is_show' => true,
                'OR' => [
                    'AND' => [
                        'Locations.badge_mobile_clinic' => true,
                        'Locations.listing_type !=' => Location::LISTING_TYPE_BASIC,
                    ],
                    'Locations.is_mobile' => true,
                ]
            ],
            'contain' => ['CallSources'],
            'fields' => $statePageFields
        ])->all();
        $this->set('mobileClinicsInState', $mobileClinicsInState ?: []);
        $mobileClinicsInStateCount = count($mobileClinicsInState);
        $this->set('mobileClinicsInStateCount', $mobileClinicsInStateCount);
        $showMobileClinics = $mobileClinicsInStateCount > 0;
        $this->set('showMobileClinics', $showMobileClinics);

        // Get telehealth clinics in a state
        $telehealthClinicsInState  = $this->Locations->find('all', [
            'conditions' => [
                'Locations.state' => $stateAbbr,
                'Locations.badge_telehearing' => true,
                'Locations.is_active' => true,
                'Locations.is_show' => true,
                'Locations.listing_type !=' => Location::LISTING_TYPE_BASIC,
            ],
            'contain' => ['CallSources'],
            'fields' => $statePageFields
        ])->all();
        $this->set('telehealthClinicsInState', $telehealthClinicsInState ?: []);
        $telehealthClinicsInStateCount = count($telehealthClinicsInState);
        $this->set('telehealthClinicsInStateCount', $telehealthClinicsInStateCount);
        $showTelehealthClinics = $telehealthClinicsInStateCount > 0;
        $this->set('showTelehealthClinics', $showTelehealthClinics);

        // Mobile and telehealth conditionals
        $this->set('stateHasMobileOrTelehealth', ($showMobileClinics || $showTelehealthClinics));
        $this->set('stateHasMobileAndTelehealth', ($showMobileClinics && $showTelehealthClinics));

        $cities = $citiesTable->findAllByState($state, true);
        $this->set('region', $this->Locations->stateRegion($state));
        $this->add_title("Trusted hearing aid specialists & audiologists in $stateNice", true);
        $this->set(compact('cities','stateNice','stateAbbr'));
        $this->meta['description'] = 'Looking for a hearing clinic near you? '. $this->siteName .' has unbiased reviews from real patients for over '. $totalClinics .' hearing aid and audiology clinics in '. $stateNice .'. '. $this->siteName .'\'s clinic directory is the best way to find local hearing aid specialists and audiologists to schedule a hearing test at a center near you.';
        //Custom Variables
        $customVars['type'] = 'state';
        $customVars['category|2'] = $stateAbbr . '-' . $this->Locations->googleRegion($state);
        $this->set('customVars',$customVars);

        // Get the total number of reviews for the country rounded to nearest hundred
        $reviews = $countMetricsTable->find('all', [
            'conditions' => [
                'metric' => 'reviews',
                'type' => 'state'
            ]
        ])->toArray();
        $reviewCounts = array_column($reviews, 'count');
        $roundedReviews = round(array_sum($reviewCounts), -2);
        $this->set('roundedReviews', number_format($roundedReviews));
        $this->set('preferredClinicsNearMe', $this->Locations->findClinicsNearMe(4, true));
        $this->set('fapterm', $this->fapSearchTerm());
    }

    // City/zip page
    public function index($region=null, $city=null, $zip=null)
    {
        pr('region = '.$region);
        pr('city = '.$city);
        pr('zip = '.$zip);
        die('TODO index()');
    }

    /**
    * Profile page
    * /hearing-aids/id-title
    */
    public function view($id = null, $title = null)
    {
        $locationId = $this->Locations->exists(['id' => Location::$oticonPrefix.$id]) ? Location::$oticonPrefix.$id : $id;
        $this->layout = 'profile';
        $location = $this->Locations->findByIdSlug($locationId, $_SERVER['REQUEST_URI']);
        if (empty($location)) {
            //If we have an id, find the right slug
            if ($redirect = $this->Locations->findForRedirectById($locationId)) {
                return $this->redirect($redirect, 301);
            } else {    //we don't have this location, kick back one level.
                $location = $this->Locations->find('all', [
                    'contain' => [],
                    'fields' => ['id', 'city', 'state', 'zip', 'title'],
                    'conditions' => ['Location.id' => $locationId]
                ])->first();
                if (!empty($location)) {
                    $this->response->disableCache();
                    // Found an inactive clinic, redirect to the zip page
                    $this->badFlash('<div class="p10"><strong><span class="glyphicon glyphicon-search pr10" aria-hidden="true"></span> '.$location->title.'</strong> is not currently listed on '.$this->siteName.'.<br>Find another clinic near '.cleanZip($location->zip).'.</div>');
                    return $this->redirect([
                        'controller' => 'locations',
                        'action' => 'index',
                        'region' => $this->Locations->stateRegion($location->state),
                        'city' => slugifyCity($location->city),
                        'zip' => slugifyZip($location->zip)
                    ], 301);
                } else {
                    throw new NotFoundException();
                }
            }
        }
        $region = $this->Locations->stateRegion($location->state);
        $city = slugifyCity($location->city);
        $zip = $location->zip;

        $this->prefetches[] = '//maps.google.com';
        $this->prefetches[] = '//fonts.google.com';
        $this->prefetches[] = '//maps.googleapis.com';

        //set up and assign the meta tag info
        $request = env('REQUEST_URI');

        $this->SeoMetaTags = $this->fetchTable('SeoMetaTags');
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
        $this->set('seoMetaTags', $seoMetaTags);

        $this->SeoTitles = $this->fetchTable('SeoTitles');
        $seoTitle = $this->SeoTitles->findTitleByUri($request);
        $this->set('seoTitle', $seoTitle);

        //Custom variables for analytics
        if ($location->is_iris_plus) {
            $membership = 'EQ';
        } elseif ($location->is_cq_premier) {
            $membership = 'CYHN';
        } else {
            $membership = 'HH';
        }
        $customVars['type'] = 'profile';
        $customVars['category|2'] = "{$location->listing_type}-{$membership}-{$location->zip}-{$location->city}-{$location->state}-" . $this->Locations->googleRegion($region);
        $customVars['level|3'] = $location->review_status.'-'.$location->completeness;

        //Meta Data
        $title = "{$location->title} in {$location->city}, {$location->state}";
        $this->meta['title'] = $title;
        $this->meta['DC.title'] = $title;
        $metaAddress = $location->is_mobile ? "mobile clinic based from" : $location->address.",";
        $this->meta['description'] = "Read verified clinic information, patient reviews and make an appointment at {$location->title}, {$metaAddress} {$location->city}, {$location->state_full} {$location->zip}.";
        $this->meta['ICBM']="{$location->lat}, {$location->lon}";
        $this->meta['geo.position']="{$location->lat};{$location->lon}";
        $this->meta['geo.placename']="{$location->city}, {$location->state_full} ({$location->state})";
        $this->meta['geo.region'] = "{$location->country}-{$location->state}";
        $this->meta['Geography']="{$location->city}, {$location->state_full} ({$location->state})";
        $this->meta['city']=$location->city;
        $this->meta['state']=$location->state_full;
        $this->meta['zip']=$location->zip;

        // See if there are any locations we want to mark 'noindex'
        // Load our config file
        //TODO: Is this needed anymore?
        /*
        Configure::load('noindex');
        // Grab the noindex locations from the config file
        $noIndexLocations = Configure::read('ids');
        // Confirm the key 'Ids' exists, that it is an array, and that this location is Oticon t3,
        // then check if our current ID is in the array. (Either as an oticon ID or a location ID)
        if (is_array($noIndexLocations) && ($location->oticon_tier == 3) && ($location->yhn_tier == 0)) {
            if (in_array($location->id_oticon, $noIndexLocations) || in_array($location->id, $noIndexLocations)) {
                $this->meta['robots'] = 'noindex';
            }
        }*/

        $this->socialOptions['og:type'] = 'business.business';
        $this->socialOptions['place:location:latitude'] = $location->lat;
        $this->socialOptions['place:location:longitude'] = $location->lon;
        $this->socialOptions['business:contact_data:street_address'] = $location->is_mobile ? null : $location->address;
        $this->socialOptions['business:contact_data:locality'] = $location->city;
        $this->socialOptions['business:contact_data:region'] = $location->state;
        $this->socialOptions['business:contact_data:country_name'] = 'US';
        $this->socialOptions['business:contact_data:postal_code'] = $location->zip;
        $this->socialOptions['business:contact_data:phone_number'] = $location->phone;
        $this->socialOptions['business:contact_data:website'] = $location->url;
        $this->socialOptions['business:hours'] = $location->location_hour;
        $this->socialOptions['article:section'] = 'Find A Hearing Clinic';
        $this->socialOptions['og:updated_time'] = $location->modified;

        //Title
        $this->add_title($title, true);

        // Look for exclusive ad for basic profiles
        if ($location->listing_type == Location::LISTING_TYPE_BASIC) {
            $exclusiveAd = $this->fetchTable('Advertisements')->findAdForBasicProfile();
            if (!empty($exclusiveAd)) {
                // Overwrite the generic ad
                $this->set('ad', $exclusiveAd);
            }
        }

        //Setting Variables
        $this->set('ratings', $this->Locations->Reviews->ratings);
        $this->set('customVars', $customVars);
        $this->set('location', $location);
        $this->set('city', $city);
        $this->set('region', $region);
        $this->set('zip', $zip);
        $this->set('title', $title);
        $this->set('fapterm', $this->fapSearchTerm());
    }

    private function fapSearchTerm(){
        $session = $this->request->getSession();
        $retval = $session->read('fapterm');
        $session->delete('fapterm');
        return $retval;
    }

    /**
     * Add Review method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function addReview()
    {
        $review = $this->Locations->Reviews->newEmptyEntity();

        $jsonRequestData = $this->request->getData('reviews');
        $jsonRequestData['status'] = ReviewStatus::PENDING->value;
        $jsonRequestData['origin'] = ReviewOrigin::ORIGIN_ONLINE->value;
        $jsonRequestData['ip'] = $this->request->getSession()->read('clientIp');

        $review = $this->Locations->Reviews->patchEntity($review, $jsonRequestData);

        if ($this->Locations->Reviews->save($review)) {
            return $this->response->withStringBody('Successfully saved!');
        }

        return $this->response->withStringBody('Failure on save!');
    }
}
