<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use App\Model\Entity\Location;
use App\Model\Entity\Review;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use DateTime;
use DateTimeZone;

/**
 * Clinic helper
 */
class ClinicHelper extends Helper
{
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
            'full' => '<i class="bi bi-star-fill"></i>',//'<span class="hh-icon-full-star"></span>',
            'half' => '<i class="bi bi-star-half"></i>',//'<span class="hh-icon-half-star"></span>',
            'empty' => '<i class="bi bi-star"></i>'//'<span class="hh-icon-outline-star"></span>'
        ];
        $rating = strval($rating);
        $retval = null;
        for ($i = 1; $i <= 5; $i++) {
            if ($rating >= $i) {
                $retval .= $stars['full'];
            } elseif(strpos($rating,'.') !== false) {
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
}
