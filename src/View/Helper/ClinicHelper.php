<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use App\Model\Entity\Location;
use App\Model\Entity\Review;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use DateTime;
use DateTimeZone;

/**
 * Clinic helper
 */
class ClinicHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Identity', 'Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        $this->Locations = TableRegistry::getTableLocator()->get('Locations');
        $this->LocationHours = TableRegistry::getTableLocator()->get('LocationHours');
        $this->lettersSeen = [];
    }

    /**
    * Return the badge of the clinic listing type.
    * @param string listing type
    * @return string span with badge
    */
    public function badgeListingType($listingType) {
        switch ($listingType) {
            case Location::LISTING_TYPE_PREMIER:  return '<span class="badge bg-success">' . $listingType . '</span>';
            case Location::LISTING_TYPE_ENHANCED:  return '<span class="badge bg-primary">' . $listingType . '</span>';
            case Location::LISTING_TYPE_BASIC:  return '<span class="badge bg-danger">' . $listingType . '</span>';
            case Location::LISTING_TYPE_NONE:  return '<span class="badge bg-info">' . $listingType . '</span>';
        }
    }

    public function badgeReview($reviewsApproved = null) {
        if (empty($reviewsApproved)) {
            $reviewsApproved = 0;
        }
        return '<span class="badge bg-info">'.$reviewsApproved.' reviews</span>';
    }

    // TO-DO: Remove this function from reviewVerification() below
    public function reviewOrigin($key = null) {
        if ($key !== null) {
            return Review::$origins[$key];
        }
    }

    /**
    * Show the signature line of a review.
    */
    public function formatReviewSignature($review = null, $options = []) {
        $isFullName = false;
        if(!empty($options['name']) && $options['name'] == 'full') {
            $isFullName = true;
        }
        $submitterFirstName = isset($review['first_name']) ? $review['first_name'] : '';
        $submitterLastName = isset($review['last_name']) ? $review['last_name'] : '';

        //build the submitter name
        $submitterText = empty($isFullName) ? $submitterFirstName . ' ' . substr($submitterLastName, 0, 1) . '.' : $submitterFirstName . ' ' . $submitterLastName;


        if (!empty($submitterText) && !isset($options['json'])) {
            return $submitterText . $this->formatCity($review);
        }
        else if (!empty($submitterText) && $options['json']) {
            return $submitterText;
        }
        return "";
    }

    /**
    * Return review body if we want to truncate
    */
    public function formatReview($body, $truncate = false) {
        $retval = "“";
        if ($truncate && strlen($body) > $truncate) {
            $retval .= $this->truncate($body, $truncate);
            $retval .= "”";
            $retval .= ' <a href="#" style="font-size: 85%;">more »</a>';
        } else {
            $retval .= $body . "”";
        }
        return $retval;
    }

    /**
    * Review city format
    */
    public function formatCity($review = null) {
        $retval = "";
        if (!empty($review->reviewer_zip)) {
            if (!empty($review->reviewer_zip->city) && !empty($review->reviewer_zip->state)) {
                $city = Inflector::humanize($review->reviewer_zip->city) .', '. strtoupper($review->reviewer_zip->state);
                $retval = " of " . $city;
            }
        }
        return $retval;
    }

    /**
    * Decide the span of stars
    */
    public function generateHalfStars($rating = 0) {
        //TODO: css for hh-icons
        $stars = [
            'full' => '<i class="bi bi-star-fill hh-icon-full-star"></i>',//'<span class="hh-icon-full-star"></span>',
            'half' => '<i class="bi bi-star-half hh-icon-half-star"></i>',//'<span class="hh-icon-half-star"></span>',
            'empty' => '<i class="bi bi-star"></i>'//'<span class="hh-icon-outline-star"></span>'
        ];
        $retval = null;
        for ($i = 1; $i <= 5; $i++) {
            if ($rating >= $i) {
                $retval .= $stars['full'];
            } elseif(strpos(strval($rating),'.') !== false) {
                $rating = 0; //no more full stars after this, set rating to 0;
                $retval .= $stars['half'];
            } else {
                $retval .= $stars['empty'];
            }
        }
        return $retval;
    }

    /**
    * Add verification images to a review
    * @param array review data
    * @return string images stacked on top of each other based on what is keyed in the review
    */
    public function reviewVerification($review = null) {
        $retval = '';
        if (isset($review->origin)) {
            switch ($this->reviewOrigin($review->origin)) {
                case 'Online':
                    $retval = '<br>Review submitted online';
                    break;
                case 'Mail':
                    $retval = '<br>Review received via mail';
                    break;
                case 'Phone':
                    $retval = '<br>Review verified by phone';
                    break;
            }
        }
        return $retval;
    }

    public function reviewSchema($location = null, $options = array()) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        $count = $location->reviews_approved;
        $rating = $location->average_rating;
        if (!$count) {
            return null;
        }
        $retval = ',"aggregateRating": {
                    "bestRating": "5",
                    "worstRating": "1",
                    "reviewCount": "'.$count.'",
                    "itemReviewed": "' . $location->title . '",
                    "ratingValue": "' . $rating . '"
                }';
        return $retval;
    }

    public function sliceReviews($reviews, $by = 5) {
        $retval = [
            0 => [],
            1 => []
        ];
        foreach ($reviews as $key => $review) {
            if ($key < $by) {
                $retval[0][] = $review;
            } else {
                $retval[1][] = $review;
            }
        }
        return $retval;
    }
    
	/**
	* Truncate text
	*/
	public function truncate($string, $limit, $pad=" ...") {
		if (strlen($string) <= $limit) {
			return $string;
		}
		$retval = substr($string, 0, $limit);
		if ($string[$limit] != ' ' && $string[$limit] != '.') {
			$offset = strrpos($retval, ' ');
			$retval = substr($retval, 0, $offset);
		}
		$retval .= $pad;
		return $retval;
	}

    public function getOpenClosedByLocationId($locationId) {
        $isEnhancedOrPremier = $this->isEnhancedOrPremierByLocationId($locationId);
        return $this->getOpenClosed($locationId, $isEnhancedOrPremier);
    }

    public function getOpenClosed($locationId, $isEnhancedOrPremier) {
        $displayOpenClosed = null;
        if (Configure::read('isOpenClosedEnabled')) {
            if ($isEnhancedOrPremier) {
                $dayOfWeek = strtolower(date('D'));
                $hours = $this->LocationHours->find('all', [
                    'contain' => [],
                    'conditions' => [
                        'location_id' => $locationId,
                    ]
                ])->first();
                if (!empty($hours) && !$hours->{$dayOfWeek.'_is_closed'}) {
                    // Clinic is open today
                    if (!empty($hours->{$dayOfWeek.'_open'}) && !empty($hours->{$dayOfWeek.'_close'})) {
                        $clinicTimezone = $this->getClinicTimezone($locationId);
                        $currentDateTime = new DateTime('now', new DateTimeZone($clinicTimezone));
                        $currentTime = $currentDateTime->getTimestamp();
                        $openTime = strtotime($hours->{$dayOfWeek.'_open'}.' '.$clinicTimezone);
                        $closeTime = strtotime($hours->{$dayOfWeek.'_close'}.' '.$clinicTimezone);
                        if (($currentTime > $openTime) && ($currentTime < $closeTime)) {
                            $isOpenNow = true;
                            $openHours = $hours->{$dayOfWeek.'_open'}.' - '.$hours->{$dayOfWeek.'_close'};
                            if ($hours->is_closed_lunch) {
                                $lunchStartTime = strtotime($hours->lunch_start.' '.$clinicTimezone);
                                $lunchEndTime = strtotime($hours->lunch_end.' '.$clinicTimezone);
                                if (($currentTime > $lunchStartTime) && ($currentTime < $lunchEndTime)) {
                                    // Currently closed for lunch. Do not display "Open now".
                                    $isOpenNow = false;
                                } elseif (($lunchStartTime > $openTime) && ($lunchEndTime < $closeTime)) {
                                    // Time will be split by lunch break
                                    $openHours = $hours->{$dayOfWeek.'_open'}.' - '.$hours->lunch_start.', '.$hours->lunch_end.' - '.$hours->{$dayOfWeek.'_close'};
                                }
                            }
                            if ($isOpenNow) {
                                if ($hours->{$dayOfWeek.'_is_byappt'}) {
                                    $displayOpenClosed = '<span class="open">Open now by appointment!</span> '.$openHours;
                                } else {
                                    $displayOpenClosed = '<span class="open">Open now!</span> '.$openHours;
                                }
                            }
                        }
                    } else if ($hours->{$dayOfWeek.'_is_byappt'}) {
                        // Show "Open by appt" during 9am-4pm clinic timezone
                        $clinicTimezone = $this->getClinicTimezone($locationId);
                        $currentDateTime = new DateTime('now', new DateTimeZone($clinicTimezone));
                        $currentTime = $currentDateTime->getTimestamp();
                        $openTime = strtotime('9:00 am '.$clinicTimezone);
                        $closeTime = strtotime('4:00 pm '.$clinicTimezone);
                        if (($currentTime > $openTime) && ($currentTime < $closeTime)) {
                            $displayOpenClosed = '<span class="open">Open today by appointment</span>';
                        }
                    }
                }
            }
        }
        return $displayOpenClosed;
    }

    public function isEnhancedOrPremierByLocationId($locationId) {
        // Returns true if this location is Enhanced or Premier
        $listingType = $this->Locations->get($locationId)->listing_type;
        return in_array($listingType, [Location::LISTING_TYPE_ENHANCED, Location::LISTING_TYPE_PREMIER]);
    }

    public function getClinicDateTime($id, $datetime, $format='m/d/Y g:i a T') {
        return $this->Locations->getClinicDateTime($id, $datetime, $format);
    }

    public function getClinicTimezone($id) {
        return $this->Locations->getClinicTimezone($id);
    }

    public function adminLink($locationId = null, $isAdmin = false) {
        if ($isAdmin) {
            return $this->Html->link('Admin Edit', ['prefix'=>'Admin', 'controller'=>'locations', 'action'=>'edit', $locationId], ['class' => 'btn btn-default btn-xs']);
        }
        return "";
    }

    public function clinicLink($locationId = null, $isClinic = false, $isAdmin = false) {
        // Admins are allowed access to all clinic links. Clinic users may be allowed access to multiple location ids.
        // TODO: TEST THIS
        $isUserAllowed = $isAdmin;
        if ($isClinic) {
            $clinicLocations = $this->Identity->get('locations');
            foreach ($clinicLocations as $clinicLocation) {
                if ($clinicLocation->id == $locationId) {
                    $isUserAllowed = true;
                }
            }
        }
        if ($isUserAllowed) {
            return $this->Html->link('Clinic Edit', ['prefix'=>'Clinic', 'controller'=>'locations', 'action'=>'edit', $locationId], ['class' => 'btn btn-default btn-xs']);
        }
        return "";
    }

    /**
    * Return the address of a location
    * @param location (optional)
    * @param mixed|array options
    *
    */
    public function address($location, $options = []) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        if (!is_array($options)) {
            $break = $options;
            $options = [];
            $options['break'] = $break;
        }
        $options = array_merge([
            'break' => false,
            'schema' => false,
        ], $options);

        if ($options['break']) {
            $break = "<br>";
        }   else {
            $break = " ";
        }

        $street = $location->address;
        if (!empty($location->address_2)) {
            $street .= " " . $location->address_2;
        }
        $city = $location->city;
        $state = $location->state;
        $zip = $location->zip;

        if ($location->is_mobile) {
            if (empty($location->mobile_text))  {
                $retval = Location::$mobileTextDefault;
            } else {
                $retval = $location->mobile_text;
            }
        } elseif ($options['schema']) {
            $retval = "<span>$street</span>$break
                <span>$city</span>,
                <span>$state</span>
                <span>$zip</span>";
        } else {
            $retval = $street . $break . $city . ', ' . $state . ' ' . $zip;
        }
        return str_replace("\n", "", $retval);
    }

    /**
    * Return the phone number of a clinic, try using the callsource number first, fallback to normal phone number
    * @param location (optional)
    * @param array of options
    * - link 'tel' | 'skype' | false (default false)
    * @return string phone number
    */
    public function phone($location = null, $options = array(), $isCallTrackingBypassed = null) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }

        $options = array_merge(array(
            'link' => false
        ),(array)$options);

        $retval = $location->phone;

        if (is_null($isCallTrackingBypassed)) {
            $isCallTrackingBypassed = TableRegistry::get('Configurations')->isCallTrackingBypassed();
        }

        if (!$isCallTrackingBypassed) {
            $callsource = '';
            foreach ($location->call_sources as $cs) {
                if (!empty($cs->is_active)) {
                    $callsource = cleanPhone($cs->phone_number);
                    break;
                }
            }
            if (!empty($callsource)) {
                $retval = $callsource;
            }
        }
        if ($options['link']) {
            $sPhone = preg_replace("/[^0-9]/",'',$retval);
            $link = $category = null;
            switch ($options['link']) {
                /*case 'skype':
                    $link = "callto://1$sPhone";
                    $category = 'Desktop-Click';
                    break;*/
                default:
                    $link = "tel:1$sPhone";
                    $category = 'Mobile-Click';
                    break;
            }
            return "<a href='$link' onclick=\"dataLayer.hhTrackEvent('Phone-Call','$category', '1$sPhone', $.Clinic.diff_time());\">". formatPhoneNumber($retval) ."</a>";

        }
        return formatPhoneNumber($retval);
    }

    /**
    * Basic Star Rating for new star ratings.
    */
    public function basicStarRating($location = null, $options = []) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        $options = array_merge([
            'showEmpty' => false,
            'showLink' => false,
        ], (array) $options);
        $rating = $location->average_rating;
        $reviewsApproved = $location->reviews_approved;
        if ($rating) {
            $s = ($reviewsApproved > 1) ? 's' : '';
            if ($options['showLink']) {
                $reviewCount = ' (<a href="#reviews">'.$reviewsApproved.' Review'.$s.'</a>)';
            } else  {
                $reviewCount = ' ('.$reviewsApproved.' Review'.$s.')';
            }
            return $this->generateHalfStars($rating) . $reviewCount;
        } else {
            //Don't show this link for Ontario, ticket #16912
            if ($options['showEmpty'] && $location->state != 'ON') {
                return $this->Html->link('Be the first to review', $location->hh_url, ['class' => 'btn-link show_clinic', 'escape' => false]);
            } else {
                return null;
            }
        }
    }

    /**
    * Return the link back of a particular locations with the title as the text
    * @param location
    * @param boolean full link (default false)
    * @return HtmlLink
    */
    public function link($location = null, $full = false, $options = array()) {
        if ($location) $this->setLocation($location);
        if ($full) {
            $url = Router::url($this->get('hh_url'), $full);
        }   else {
            $url = $this->get('hh_url');
        }

        return $this->Html->link($this->get('title'), $url, $options);
    }

    /**
    * Display the hours of a clinic
    * @param location (optional)
    * @return mixed
    */
    public function hours($location = null) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        $retval = null;
        if (!empty($location->location_hour)) {
            $empty_count = 0;
            $days = $this->LocationHours->days;
            $hours = $location->location_hour;
            foreach ($days as $day) {
                $empty = false;
                if (empty($hours[$day.'_open']) && empty($hours[$day.'_close']) && $hours[$day.'_is_byappt']==false && $hours[$day.'_is_closed']==false) {
                    $empty_count++;
                    $empty = true;
                }
                $time = 'Closed';
                if ($hours[$day.'_is_closed'] == true) {
                    $time = 'Closed';
                } else if ($hours[$day.'_is_byappt'] == true) {
                    $time = 'Open by appointment';
                }
                if ($hours[$day.'_open'] != "" && $hours[$day.'_close'] != "" && $hours[$day.'_is_closed']==false) {
                    $open = str_replace(":00", "", $hours[$day.'_open']);
                    $close = str_replace(":00", "", $hours[$day.'_close']);
                    $time = $open.' - '.$close;
                    if ($hours['is_closed_lunch']) {
                        $lunchStart = str_replace(":00", "", $hours['lunch_start']);
                        $lunchEnd = str_replace(":00", "", $hours['lunch_end']);
                        if ((strtotime($lunchStart) > strtotime($open)) && (strtotime($lunchEnd) < strtotime($close))) {
                            // Time will be split by lunch break
                            // Remove extra am/pm if possible to shorten
                            if ($this->getMeridian($open) == $this->getMeridian($lunchStart)) {
                                $open = str_replace([" am", " pm"], "", $open);
                            }
                            if ($this->getMeridian($lunchEnd) == $this->getMeridian($close)) {
                                $lunchEnd = str_replace([" am", " pm"], "", $lunchEnd);
                            }
                            $time = $open.' - '.$lunchStart.', '.$lunchEnd.' - '.$close;
                        }
                    }

                    if ($hours[$day.'_is_byappt'] == true) {
                        $time .= '<br>by appointment';
                    }
                }
                switch ($day) {
                    case 'mon':
                        $daytitle = "Monday";
                        break;
                    case 'tue':
                        $daytitle = "Tuesday";
                        break;
                    case 'wed':
                        $daytitle = "Wednesday";
                        break;
                    case "thu":
                        $daytitle = 'Thursday';
                        break;
                    case 'fri':
                        $daytitle = 'Friday';
                        break;
                    case 'sat':
                        $daytitle = 'Saturday';
                        break;
                    case 'sun':
                        $daytitle = 'Sunday';
                        break;
                }
                if (trim($time) != "-" && !empty($time) && !$empty) {
                    $retval .= '<tr><td>'.$daytitle.'</td><td>'.$time.'</td></tr>';
                }

            }
            if ($location->is_evening_weekend_hours) {
                $retval .= "<tr><td colspan=\"2\">Evening and/or weekend hours available by appointment. Please call to schedule.</td></tr>";
            }
        }
        if (!empty($retval)) {
            $retval = '<table class="table table-condensed">'.$retval.'</table>';
        }
        return $retval;
    }

    private function getMeridian($time) {
        $meridian = "";
        if (stripos($time, "am") !== false) {
            $meridian = "am";
        } elseif (stripos($time, "pm") !== false) {
            $meridian = "pm";
        }
        return $meridian;
    }

    /**
    * Load a provider image, but only if it exists on the server
    * @param provider
    * @return string HTML image or empty
    */
    public function providerImage($provider = null, $options = array()) {
        if (!is_object($provider)) {
            $provider = $this->Providers->get($provider);
        }
        //Changing
        if (is_bool($options)) {
            $url_only = $options;
            $options = array();
            $options['url_only'] = $url_only;
        }
        $options = array_merge(array(
            'url_only' => false
        ),(array) $options);

        if (isset($provider->file->tmp_name) && !empty($provider->file->tmp_name)) {
            return $this->Html->image('/tmp/' . $provider->file->name, array('width' => 150));
        }
        if (!empty($provider->thumb_url)) {
            $filename = basename($provider->thumb_url);
            $url = "/cloudfiles/clinicians/" . rawurlencode($filename);
            $classLead = ' class="';
            $classClose = '"';
            if ($options['url_only']) {
                return $url;
            }
            if (!isset($options['class'])){
                $options['class'] = '';
                $classLead = '';
                $classClose = '';
            }
            if (!isset($options['alt'])){
                $options['alt'] = '';
            }
            if (!isset($options['width'])){
                $options['width'] = '';
            }
            if (!isset($options['height'])){
                $options['height'] = '';
            }
            unset($options['url_only']);
            return '<div class="profile-pic-container"><img src="'.$url.'" loading="lazy"' . $classLead . $options['class'] . $classClose . ' alt="'.$options['alt'].'" width="'.$options['width'].'" height="'.$options['height'].'"></div>';
        }
        /*
        $image_path = WWW_ROOT . $provider->thumb_url;
        if(!empty($provider->thumb_url) && file_exists($image_path)){
        return $this->Html->image($provider->thumb_url);
        }*/
        return "";
    }

    // Display linked locations on the clinic profile page
    public function linkedLocations($locationId) {
        $retval = '';
        // Returns all linked locations sorted by distance
        $distanceArray = $this->Locations->findLocationLinksByDistance($locationId);
        $count = 0;
        foreach ($distanceArray as $linkedLocationId => $distance) {
            $linkedLocation = $this->Locations->get($linkedLocationId);
            $title = $linkedLocation->title;
            $hhUrl = $linkedLocation->hh_url;
            // Only display active/show clinics
            if (!empty($title)) {
                $retval .= empty($retval) ? '' : '<hr>';
                $retval .= '<div class="linked-location">';
                $retval .= $this->Html->link(
                    $title,
                    $hhUrl,
                    ['escape' => false, 'class' => 'text-link']
                );
                $retval .= '<br><span class="text-caption"><span class="hh-icon-address"></span> ' . $this->address($linkedLocation, true) . '</span>';
                $retval .= '<br>'.$this->Html->link('View Details', $hhUrl, ['class' => 'btn btn-sm btn-primary mt5']);
                $retval .= '</div>';
                $count++;
                // Only display up to 5 closest clinics
                if ($count == 5) {
                    break;
                }
            }
        }
        return $retval;
    }

    public function newMethodOfPayment($location) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        $retval = "";
        //Show list of payment types accepted
        if (!empty($location->payment)) {
            $payment_array = json_decode($location->payment, true);
            $rows = array();
            $cards_to_show = array();
            $payments = $this->Locations->payments;
            foreach ($payment_array as $methodindex => $methodvalue) {
                if ($methodvalue == 1) {
                    @$rows[] = $this->Html->tag('li', $payments[$methodindex]['name'], array('escape' => false));
                    if (!empty($payments[$methodindex]['icon'])) {
                        //$cards_to_show[] = $methodindex; //dont show icons
                    }
                }
            }

            $retval = $this->Html->tag('ul', implode('', $rows), array('class' => 'no-bullets'));

            //Show list of cards
            $cards = '<p class="text-center">';
            foreach ($cards_to_show as $card_index){
                $cards .= ' ' . $this->Html->image("/images/{$payments[$card_index]['icon']}", array('alt' => $payments[$card_index]['name'], 'title' => $payments[$card_index]['name'], 'class' => 'pr10'));
            }
            $cards .= "</p>";

            $retval = $cards . $retval;
        }

        if ($retval == '<p class="text-center"></p><ul class="no-bullets"></ul>') {
            $retval = null;
        }
        return $retval;
    }

    public function nearMe($clinicsNearMe = [], $template = null) {
        if ($this->isDifferentCountry()) {
            return 'locations/near_me/different_country';
        }
        if ($template === 'nav_bar') {
            return 'locations/near_me/nav_bar';
        } else if ($template === 'details') {
            return 'locations/near_me/details';
        }
        return 'locations/near_me/default';
    }

    public function isDifferentCountry() {
        $geoLocData = $_SESSION['geoLocData'];
        if (isset($geoLocData['country']) && ($geoLocData['country'] != Configure::read('country'))) {
            return true;
        }
        return false;
    }

    public function nearMeLink() {
        $geoLocData = $_SESSION['geoLocData'];
        if (isset($geoLocData['state'])) {
            $region = $this->Locations->stateRegion($geoLocData['state']);
        }
        if (isset($geoLocData['country']) && ($geoLocData['country'] != Configure::read('country'))) {
            $nearMeLink = Router::url(['controller' => 'locations', 'prefix'=>false, 'plugin'=>false, 'action' => 'viewFac']);
        } elseif (isset($geoLocData['zip']) && isset($geoLocData['city']) && !empty($region)) {
            $nearMeLink = Router::url(['controller' => 'locations', 'prefix'=>false, 'plugin'=>false, 'action' => 'index', 'region' => $region, 'city' => slugifyCity($geoLocData['city']), 'zip' => $geoLocData['zip']]);
        } elseif (isset($geoLocData['city']) && !empty($region)) {
            $nearMeLink = Router::url(['controller' => 'locations', 'prefix'=>false, 'plugin'=>false, 'action' => 'index', 'region' => $region, 'city' => slugifyCity($geoLocData['city'])]);
        } else {
            $nearMeLink = Router::url(['controller' => 'locations', 'prefix'=>false, 'plugin'=>false, 'action' => 'viewFac']);
        }
        return $nearMeLink;
    }

    /**
    * Show the clinic url
    * format for a link
    */
    public function website($location, $return = 'link') {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        $url = trim($location->url);
        if (!empty($url)) {
            // Verify the URL starts with http or https
            $url = strpos($url, 'http') === false ? 'http://' . $url : $url;
            if($return == 'uri') {
                return $url;
            }
            $parts = parse_url($url);
            return $this->Html->link('Clinic website', $url, ['target' => '_blank', 'type' => 'clinic link', 'class' => 'text-link', 'rel' => 'noopener', 'escape' => false]);
        }
        return null;
    }

    /**
    * Social bar on profile
    */
    public function social($location) {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }
        $retval = "";
        $socials = [];
        if ($location->facebook || $location->twitter || $location->youtube) {
            if ($text = $this->socialType($location, 'facebook')) {
                $socials[] = $text;
            }
            if ($text = $this->socialType($location, 'twitter')) {
                $socials[] = $text;
            }
            if ($text = $this->socialType($location, 'youtube')) {
                $socials[] = $text;
            }
            $retval .= implode('<br>',$socials);
        }
        return $retval;
    }

    /**
    * Get the specific link
    * Note: This code matches some checks in LocationsShell::redirectClinicWebsites().
    *       If this code changes, please make sure to update that function as well.
    */
    public function socialType($location, $key = 'facebook') {
        if (!is_object($location)) {
            $location = $this->Locations->get($location);
        }

        $social = $location->$key;
        if (!$social) {
            return null;
        }

        //Not empty, continue.
        switch ($key) {
            case 'facebook':
                $text = str_replace(array('https://','http://','www.facebook.com/','facebook.com/'), '', $social);
                return '<span class="facebook"><span class="hh-icon-facebook clinic-share"></span> ' . $this->Html->link(
                    'Facebook',
                    'https://www.facebook.com/' . $text,
                    ['class' => 'text-link', 'escape' => false, 'target' => '_blank', 'rel' => 'noopener']
                ) . '</span>';
            case 'twitter':
                $text = str_replace(array('https://twitter.com/','https://www.twitter.com/'), '', $social);
                return '<span class="twitter"><span class="hh-icon-twitter clinic-share"></span> ' . $this->Html->link(
                    'Twitter',
                    'https://twitter.com/' . $text,
                    ['class' => 'text-link', 'escape' => false, 'target' => '_blank', 'rel' => 'noopener']
                ) . '</span>';
            case 'youtube':
                $youtubeLink = 'https://www.youtube.com/';
                $youtubeSuffix = '';
                if(preg_match('/^http/', $social)) {
                    $youtubeLink = $social;
                } else {
                    //need to determine if its a channel or a user
                    if(preg_match('/^(UC|HC)/', $social)) {
                        $youtubeSuffix = 'channel/' . $social;
                    } elseif(preg_match('/^channel/', $social)) {
                        $youtubeSuffix = $social;
                    } else {
                        //not a channel, it's a user. Strip out any user prefix and build the URL
                        $youtubeSuffix = 'user/' . preg_replace('~^user/~', '', $social);
                    }
                }
                return '<span class="youtube"><span class="hh-icon-youtube clinic-share"></span> ' . $this->Html->link(
                    'YouTube',
                    $youtubeLink . $youtubeSuffix,
                    ['class' => 'text-link', 'escape' => false, 'target' => '_blank', 'rel' => 'noopener']
                ) . '</span>';
            default: return null;
        }
    }

    /**
    * Address link for responsive sidebar.
    * @param location (optional)
    * @return string link
    */
    public function addressLink($location = null) {
        $link = $this->Html->link($location->title, $location->hh_url, ['escape' => false, 'class' => 'text-link']);
        $retval = $link . '<br>' . $this->address($location, true);

        if ($location->reviews_approved > 0) {
            $retval .= '<div class="reviews text-small"><a href="' . Router::url($location->hh_url) . '#reviews" style="border:none" onclick="' . $this->zipResultsClickEvent($location) . '">' . $this->basicStarRating($location) . '</a></div>';
        }

        $retval .= $this->Html->tag('p', $this->Html->link('View Details', $location->hh_url, ['class' => 'btn btn-secondary']), ['class' => 'mt10 mb0 text-small']);
        return $retval;
    }

    /**
    * Generate the onclick event used for the city/zip results page
    * @param object Location
    * @return string
    */
    public function zipResultsClickEvent($location = null) {
        $listingType = !empty($location->listing_type) ? $location->listing_type : Location::LISTING_TYPE_NONE;
        $clickEvent = "dataLayer.hhTrackEvent('CityPageClicks','" . $listingType . "Click', document.location.pathname, 0, false);";
        return $clickEvent;
    }

    /**
    * THis will decide if we need to show the city letter header
    * @param city
    * @return string html h4 tag or empty string
    */
    public function showCityLetterLine($city) {
        $retval = "";
        $first_letter = strtoupper($city[0]);
        if (empty($this->lettersSeen[$first_letter])) {
            $isFirst = count($this->lettersSeen) == 0;
            $this->lettersSeen[$first_letter] = true;
            if ($isFirst) {
                $retval = '<li><h3 class="list-header">'. $first_letter .'</h3></li>';
            }   else {
                $retval = '<li><h3 class="list-header mt30">'. $first_letter .'</h3></li>';
            }
        }
        return $retval;
    }

    /**
    * Return a state slug based on state
    * @param string state
    * @return string slug
    */
    public function stateSlug($state) {
        return $this->Locations->stateSlug($state);
    }

    /**
     * @description Returns the count from the count_metrics data set
     *
     * @param $name string Primary selector, usually a city name, state name or zip code
     * @param string $metric Metric to check
     * @param string $type Segmentation level
     * @param string $subName Secondary selector, only used for city
     *
     * @return int count value
     */
    public function getCount($name, $metric = 'clinics', $type = 'state', $subName = '')
    {
        return TableRegistry::get('CountMetrics')->getCount($name, $metric, $type, $subName);
    }

    public function isEnhancedOrPremierByLocationArray($location) {
        // Returns true if this location is Enhanced or Premier
        return in_array($location->listing_type, ['Premier', 'Enhanced']);
    }

    public function getOpenClosedByLocationArray($location) {
        $isEnhancedOrPremier = $this->isEnhancedOrPremierByLocationArray($location);
        return $this->getOpenClosed($location->id, $isEnhancedOrPremier);
    }
}
