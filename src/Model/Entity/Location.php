<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Location Entity
 *
 * @property int $id
 * @property string $id_oticon
 * @property string $id_parent
 * @property string|null $id_sf
 * @property string $title
 * @property string|null $subtitle
 * @property string $address
 * @property string|null $address_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property bool $is_mobile
 * @property string $mobile_text
 * @property int $radius
 * @property string $phone
 * @property float|null $lat
 * @property float|null $lon
 * @property string|null $email
 * @property string|null $logo_url
 * @property string|null $url
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $youtube
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $is_listing_type_frozen
 * @property \Cake\I18n\FrozenDate|null $frozen_expiration
 * @property int $oticon_tier
 * @property int $yhn_tier
 * @property int $cqp_tier
 * @property string $listing_type
 * @property bool $is_ida_verified
 * @property string $location_segment
 * @property string $entity_segment
 * @property int $title_status
 * @property int $address_status
 * @property int $phone_status
 * @property bool $is_title_ignore
 * @property bool $is_address_ignore
 * @property bool $is_phone_ignore
 * @property bool $is_active
 * @property bool $is_show
 * @property bool $is_grace_period
 * @property \Cake\I18n\FrozenDate|null $grace_period_end
 * @property bool $is_geocoded
 * @property bool $filter_has_photo
 * @property bool $filter_insurance
 * @property bool $filter_evening_weekend
 * @property bool $filter_adult_hearing_test
 * @property bool $filter_hearing_aid_fitting
 * @property bool $badge_coffee
 * @property bool $badge_wifi
 * @property bool $badge_parking
 * @property bool $badge_curbside
 * @property bool $badge_wheelchair
 * @property bool $badge_service_pets
 * @property bool $badge_cochlear_implants
 * @property bool $badge_ald
 * @property bool $badge_pediatrics
 * @property bool $badge_mobile_clinic
 * @property bool $badge_financing
 * @property bool $badge_telehearing
 * @property bool $badge_asl
 * @property bool $badge_tinnitus
 * @property bool $badge_balance
 * @property bool $badge_home
 * @property bool $badge_remote
 * @property bool $badge_mask
 * @property bool $badge_spanish
 * @property bool $badge_french
 * @property bool $badge_russian
 * @property bool $badge_chinese
 * @property bool $feature_content_library
 * @property \Cake\I18n\FrozenDate|null $content_library_expiration
 * @property bool $feature_special_announcement
 * @property \Cake\I18n\FrozenDate|null $special_announcement_expiration
 * @property string|null $payment
 * @property string|null $services
 * @property string|null $slogan
 * @property string|null $about_us
 * @property float $average_rating
 * @property int $reviews_approved
 * @property string $review_status
 * @property \Cake\I18n\FrozenDate|null $last_review_date
 * @property string|null $last_xml
 * @property int|null $last_note_status
 * @property int|null $last_import_status
 * @property \Cake\I18n\FrozenTime|null $last_contact_date
 * @property bool $is_last_edit_by_owner
 * @property \Cake\I18n\FrozenTime|null $last_edit_by_owner_date
 * @property string|null $priority
 * @property string $completeness
 * @property string|null $redirect
 * @property string|null $landmarks
 * @property int $email_status
 * @property bool $is_email_ignore
 * @property string $id_yhn_location
 * @property string|null $id_cqp_practice
 * @property string|null $id_cqp_office
 * @property int|null $review_needed
 * @property bool $is_retail
 * @property string $direct_book_type
 * @property string $direct_book_url
 * @property string $direct_book_iframe
 * @property bool $is_yhn
 * @property bool $is_hh
 * @property bool $is_cqp
 * @property bool $is_cq_premier
 * @property bool $is_iris_plus
 * @property bool $is_call_assist
 * @property string $timezone
 * @property string $optional_message
 * @property bool $is_service_agreement_signed
 * @property bool $is_junk
 * @property int|null $id_coupon
 * @property bool $is_email_allowed
 *
 * @property \App\Model\Entity\CaCallGroup[] $ca_call_groups
 * @property \App\Model\Entity\CallSource[] $call_sources
 * @property \App\Model\Entity\CsCall[] $cs_calls
 * @property \App\Model\Entity\ImportLocation[] $import_locations
 * @property \App\Model\Entity\ImportStatus[] $import_status
 * @property \App\Model\Entity\LocationAd[] $location_ads
 * @property \App\Model\Entity\LocationEmail[] $location_emails
 * @property \App\Model\Entity\LocationHour[] $location_hours
 * @property \App\Model\Entity\LocationLink[] $location_links
 * @property \App\Model\Entity\LocationNote[] $location_notes
 * @property \App\Model\Entity\LocationPhoto[] $location_photos
 * @property \App\Model\Entity\LocationsProvider[] $locations_providers
 * @property \App\Model\Entity\LocationUser[] $location_users
 * @property \App\Model\Entity\LocationVidscrip[] $location_vidscrips
 * @property \App\Model\Entity\Review[] $reviews
 */
class Location extends Entity
{
    protected $_virtual = ['is_oticon', 'state_full', 'hh_url', 'slug'];
    static $oticonPrefix = '81190';
    static $mobileTextDefault = 'Mobile clinic - we come to you!';
    static $northGeorgiaAudiology = ['8119025606', '8119025842', '8119026657'];

    /**
    * Enum - Listing Type
    */
    const LISTING_TYPE_BASIC = 'Basic';
    const LISTING_TYPE_ENHANCED = 'Enhanced';
    const LISTING_TYPE_PREMIER = 'Premier';
    const LISTING_TYPE_NONE = 'None';
    static $listingTypes = [
        self::LISTING_TYPE_BASIC => 'Basic',
        self::LISTING_TYPE_ENHANCED => 'Enhanced',
        self::LISTING_TYPE_PREMIER => 'Premier',
        self::LISTING_TYPE_NONE => 'None (not shown in directory)'
    ];
    static $preferredListingTypes = [self::LISTING_TYPE_ENHANCED, self::LISTING_TYPE_PREMIER];

    /**
    * Enum - Status of address, phone, title, and email fields. Comparing Oticon import values
    *        to what we have stored in our database. Are they new, same, or different?
    */
    const CHANGE_STATUS_NO_DIFFERENCE = 0;
    const CHANGE_STATUS_DIFFERENT = 1;
    const CHANGE_STATUS_NEW = 2;
    static $changeStatuses = [
        self::CHANGE_STATUS_NO_DIFFERENCE => 'No Difference',
        self::CHANGE_STATUS_DIFFERENT => 'Different',
        self::CHANGE_STATUS_NEW => 'New',
    ];

    /**
    * Enum - clinic description status (completeness)
    */
    const COMPLETENESS_COMPLETE = 'Complete';
    const COMPLETENESS_BASIC_INFO = 'BasicInfo';
    const COMPLETENESS_PROFILE_PIC = 'ProfilePic';
    const COMPLETENESS_INCOMPLETE = 'Incomplete';
    static $completenessFields = [
        self::COMPLETENESS_COMPLETE => 'Complete',
        self::COMPLETENESS_BASIC_INFO => 'BasicInfo (missing provider data)',
        self::COMPLETENESS_PROFILE_PIC => 'ProfilePic (missing basic clinic info)',
        self::COMPLETENESS_INCOMPLETE => 'Incomplete',
    ];

    /**
    * Enum - review status
    */
    const REVIEW_STATUS_5_PLUS = 'Review5Plus';
    const REVIEW_STATUS_4_LESS = 'Review4Less';
    static $reviewStatuses = [
        self::REVIEW_STATUS_5_PLUS => 'Review5Plus (5 or more active reviews)',
        self::REVIEW_STATUS_4_LESS => 'Review4Less (4 or less active reviews)',
    ];

    /**
    * Enum - Direct Book
    */
    const DIRECT_BOOK_NONE = 'None';
    const DIRECT_BOOK_DM = 'DM';
    const DIRECT_BOOK_BLUEPRINT = 'Blueprint';
    const DIRECT_BOOK_EARQ = 'EarQ';
    static $directBookTypes = [
        self::DIRECT_BOOK_NONE => 'None (call clinic)',
        self::DIRECT_BOOK_DM => 'Diary Management',
        self::DIRECT_BOOK_BLUEPRINT => 'Blueprint',
        self::DIRECT_BOOK_EARQ => 'EarQ'
    ];

    static $badgeFields = ['badge_coffee', 'badge_wifi', 'badge_parking', 'badge_curbside', 'badge_wheelchair', 'badge_service_pets', 'badge_cochlear_implants', 'badge_ald', 'badge_pediatrics', 'badge_mobile_clinic', 'badge_financing', 'badge_telehearing', 'badge_asl', 'badge_tinnitus', 'badge_balance', 'badge_home', 'badge_remote', 'badge_mask', 'badge_spanish', 'badge_french', 'badge_russian', 'badge_chinese'];

    protected function _getIsOticon()
    {
        $country = Configure::read('country');
        if ($country == 'US') {
            return (empty($this->last_xml)) ? false : true;
        } elseif ($country == 'CA') {
            return ($this->is_retail == false) ? true : false;
        } else {
            return false;
        }
    }

    protected function _getStateFull()
    {
        $stateFull = empty($this->state) ? '' : $this->__stateFull($this->state);
        return $stateFull;
    }

    protected function _getHhUrl()
    {
        if (!empty($this->title)) {
            $hhUrl = Router::url([
                'prefix' => false,
                'plugin' => false,
                'controller' => 'locations',
                'action' => 'view',
                'id' => preg_replace('/^'. self::$oticonPrefix .'/', '', (string)$this->id),
                'title' => Text::slug(strtolower($this->title)),
            ]);
            return $hhUrl;
        } else {
            return '';
        }
    }

    protected function _getSlug()
    {
        $slug = empty($this->title) ? '' : Text::slug(strtolower($this->title));
        return $slug;
    }

    /**
    * Handy shortcut function to return a full/abbr state by searching through the states array
    * @param string $state_input
    * @return string $state_full
    */
    private function __state($get,$stateInput) {
        $stateInput = trim($stateInput);
        $states = Configure::read('states');
        foreach ($states as $state => $stateFull) {
            if (strtoupper($stateInput) == strtoupper($state) || strtoupper($stateInput)==strtoupper($stateFull)) {
                if ($get=='full') {
                    return $stateFull;
                } else {
                    return $state;
                }
            }
        }
        return null;
    }
    /**
    * Handy shortcut function to return a full state by searching through the states array
    * @param string $state_input
    * @return string $state_full
    */
    private function __stateFull($state_input) {
        return $this->__state('full',$state_input);
    }
    /**
    * Handy shortcut function to return a abbr state by searching through the states array
    * @param string $state_input
    * @return string $state_abbr
    */
    private function __stateAbbr($state_input) {
        return $this->__state('abbr',$state_input);
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id_oticon' => true,
        'id_parent' => true,
        'id_sf' => true,
        'title' => true,
        'subtitle' => true,
        'address' => true,
        'address_2' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'country' => true,
        'is_mobile' => true,
        'mobile_text' => true,
        'radius' => true,
        'phone' => true,
        'lat' => true,
        'lon' => true,
        'email' => true,
        'logo_url' => true,
        'url' => true,
        'facebook' => true,
        'twitter' => true,
        'youtube' => true,
        'created' => true,
        'modified' => true,
        'is_listing_type_frozen' => true,
        'frozen_expiration' => true,
        'oticon_tier' => true,
        'yhn_tier' => true,
        'cqp_tier' => true,
        'listing_type' => true,
        'is_ida_verified' => true,
        'location_segment' => true,
        'entity_segment' => true,
        'title_status' => true,
        'address_status' => true,
        'phone_status' => true,
        'is_title_ignore' => true,
        'is_address_ignore' => true,
        'is_phone_ignore' => true,
        'is_active' => true,
        'is_show' => true,
        'is_grace_period' => true,
        'grace_period_end' => true,
        'is_geocoded' => true,
        'filter_has_photo' => true,
        'filter_insurance' => true,
        'filter_evening_weekend' => true,
        'filter_adult_hearing_test' => true,
        'filter_hearing_aid_fitting' => true,
        'badge_coffee' => true,
        'badge_wifi' => true,
        'badge_parking' => true,
        'badge_curbside' => true,
        'badge_wheelchair' => true,
        'badge_service_pets' => true,
        'badge_cochlear_implants' => true,
        'badge_ald' => true,
        'badge_pediatrics' => true,
        'badge_mobile_clinic' => true,
        'badge_financing' => true,
        'badge_telehearing' => true,
        'badge_asl' => true,
        'badge_tinnitus' => true,
        'badge_balance' => true,
        'badge_home' => true,
        'badge_remote' => true,
        'badge_mask' => true,
        'badge_spanish' => true,
        'badge_french' => true,
        'badge_russian' => true,
        'badge_chinese' => true,
        'feature_content_library' => true,
        'content_library_expiration' => true,
        'feature_special_announcement' => true,
        'special_announcement_expiration' => true,
        'payment' => true,
        'services' => true,
        'slogan' => true,
        'about_us' => true,
        'average_rating' => true,
        'reviews_approved' => true,
        'review_status' => true,
        'last_review_date' => true,
        'last_xml' => true,
        'last_note_status' => true,
        'last_import_status' => true,
        'last_contact_date' => true,
        'is_last_edit_by_owner' => true,
        'last_edit_by_owner_date' => true,
        'priority' => true,
        'completeness' => true,
        'redirect' => true,
        'landmarks' => true,
        'email_status' => true,
        'is_email_ignore' => true,
        'id_yhn_location' => true,
        'id_cqp_practice' => true,
        'id_cqp_office' => true,
        'review_needed' => true,
        'is_retail' => true,
        'direct_book_type' => true,
        'direct_book_url' => true,
        'direct_book_iframe' => true,
        'is_yhn' => true,
        'is_hh' => true,
        'is_cqp' => true,
        'is_cq_premier' => true,
        'is_iris_plus' => true,
        'is_call_assist' => true,
        'timezone' => true,
        'optional_message' => true,
        'is_service_agreement_signed' => true,
        'is_junk' => true,
        'id_coupon' => true,
        'is_email_allowed' => true,
        'ca_call_groups' => true,
        'call_sources' => true,
        'cs_calls' => true,
        'import_locations' => true,
        'import_status' => true,
        'location_ads' => true,
        'location_emails' => true,
        'location_hours' => true,
        'location_links' => true,
        'location_notes' => true,
        'location_photos' => true,
        'providers' => true,
        'location_users' => true,
        'location_vidscrips' => true,
        'reviews' => true,
        'is_oticon' => true,
    ];
}
