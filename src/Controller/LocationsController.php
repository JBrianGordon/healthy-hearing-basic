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
use Cake\Utility\Inflector;

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

    // City/zip page ( previously called index() )
    public function viewCityZip($region='', $city='', $zip='')
    {
        $this->Cities = $this->fetchTable('Cities');
        $zip = cleanZip($zip);

        if (!empty($region)) {
            // Format the state correctly and make sure it is valid for this country
            $region = $this->Locations->stateRegion($region);
            if (empty($region)) {
                // An invalid state was passed
                return $this->throw404NotFound();
            }
            $state = $this->Locations->parseStateSlug($region);
            $stateNice = $this->Locations->stateFull($state);
            $stateAbbr = $this->Locations->stateAbbr($state);
        }

        if ($city) {
            // Verify that the city here matches the "clean" version.  If not, redirect so we don't get duplicate pages.
            $cleanCity = cleanCityName($city);
            $slugifiedCity = slugifyCity($cleanCity);
            if (strtolower($city) != strtolower($slugifiedCity)) {
                return $this->redirect([
                    'controller' => 'locations',
                    'action' => 'viewCityZip',
                    'region' => $region,
                    'city' => $slugifiedCity,
                    'zip' => slugifyZip($zip)
                ], 301);
            }
            $cityData = $this->Cities->find('all', [
                'conditions' => [
                    'city LIKE' => '%'.$cleanCity.'%',
                    'state' => $state
                ],
            ])->first();
            if (empty($cityData)) {
                // No matching city was found
                //TODO: define throw404NotFound()
                return $this->throw404NotFound();
            }
        }
        if (!empty($zip)) {
            // Verify that this is a valid zip in our zip table. If not, redirect to city page.
            if (!$this->fetchTable('Zips')->exists($zip)) {
                $zip = null;
            }
        }
        if ($redirect = $this->Locations->findRedirectByRegionCityZip(compact('region','city','zip'), $_SERVER['REQUEST_URI'])) {
            // Self-heal URL
            return $this->redirect($redirect, 301);
        }
        $contain = ['CallSources'];
        $fields = array_merge(['Location.id', 'is_call_assist', 'is_iris_plus', 'direct_book_type', 'direct_book_iframe', 'listing_type', 'logo_url', 'lat', 'lon', 'reviews_approved', 'average_rating', 'last_review_date', 'title', 'address', 'address_2', 'city', 'state', 'zip', 'phone', 'is_mobile', 'mobile_text', 'filter_has_photo'], Location::$badgeFields);
        $locations = $this->Locations->findAllByGeoLoc(compact('region','city','zip'), 40, [], $contain, $fields);

        // We are not currently using filters. Keep this code in case we decide to add them back.
        //$filters = $this->getFilters();
        //$locations = $this->filterResults($locations, $filters);

        if (empty($locations)) {
            // Found no clinics for this city. Check for any SEO redirects.
            $this->catch404();
            if (http_response_code() != '200') {
                // A redirect or status code was found
                return;
            }
        }

        //set up and assign the meta tag info
        $request = env('REQUEST_URI');

        $this->SeoMetaTags = $this->fetchTable('SeoMetaTags');
        $seoMetaTags = $this->SeoMetaTags->findAllTagsByUri($request);
        $this->set('seoMetaTags', $seoMetaTags);

        $this->SeoTitles = $this->fetchTable('SeoTitles');
        $seoTitle = $this->SeoTitles->findTitleByUri($request);
        $this->set('seoTitle', $seoTitle);

        if (!$cityData->is_near_location) {
            $this->meta['robots'] = "NOINDEX, FOLLOW";
        }
        $titleTag = 'Trusted hearing aid specialists & audiologists ' . Inflector::humanize($city) . ', ' . $stateAbbr;
        $this->add_title($titleTag,true);

        $this->meta['description'] = 'Find trusted hearing clinics, specialists and audiologists in ' . Inflector::humanize($city) . ', ' . $stateAbbr . '. '. $this->siteName .' has unbiased reviews for ' . count($locations) . ' audiology clinics near you.';

        //TODO:
        //if ($this->RequestHandler->isAjax()) {
        //    $this->set('locations', $locations);
        //    return $this->render('ajax_results');
        //}

        $reviewCount = $this->Locations->reviewCountLocations($locations);

        if ($zip) { //Add Canonial
            $this->set('canonical', array('controller'=>'locations', 'action'=>'viewCityZip', 'region'=>$region, 'city'=>$city));
        }

        //If source ppc, add a canonical link back to the url without the source
        if ($this->isPPC()) {
            $this->set('canonical', '/' . $this->request->url);
        }

        //customVars
        if ($zip) {
            $customVars['type'] = 'zip';
            $customVars['category|2'] = $zip . '-' . $city . '-' . $stateAbbr . '-' . $this->Locations->googleRegion($state);
        } elseif ($city) {
            $customVars['type'] = 'city';
            $customVars['category|2'] = $city . '-' . $stateAbbr . '-' . $this->Locations->googleRegion($state);
            $customVars['level|3'] = empty($cityData->population) ? 0 : $cityData->population;
        }
        $lastImport = $this->Locations->ImportStatus->find('all', [
            'fields' => 'ImportStatus.created',
            'order' => 'ImportStatus.created DESC'
        ])->first();
        $this->socialOptions['og:type'] = 'article';
        $this->socialOptions['article:section'] = 'Find A Hearing Clinic';
        if (!empty($lastImport)) {
            $this->socialOptions['article:modified_time'] = $lastImport->created;
        }
        $this->set('city', $city);
        $this->set('region', $region);
        $this->set('zip', $zip);
        $this->set('state', $stateNice);
        $this->set('locations', $locations);
        $this->set('customVars', $customVars);
        $this->set('reviewCount', $reviewCount);
        $showAdditionalGA = $this->turnAdditionGoogleCodeOn();
        $this->set('showAdditionalGA', $showAdditionalGA);
        $this->set('fapterm', $this->fapSearchTerm());
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
                        'action' => 'viewCityZip',
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

    /**
    * Look at the referrer and if it came from healthyhearing
    * DO NOT TURN ON THE ADDITIONAL GOOGLE ANALYTICS CODE
    * @return boolean
    */
    protected function turnAdditionGoogleCodeOn(){
        //TODO: This needs to be tested
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        return (stripos($referer, ".healthyhearing.") == false);
    }
}
