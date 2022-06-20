<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use App\Model\Entity\Location;

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
            case Location::LISTING_TYPE_NONE:  return '<span class="badge bg-secondary">' . $listingType . '</span>';
        }
    }

    public function badgeReview($reviewsApproved = null) {
        if (empty($reviewsApproved)) {
            $reviewsApproved = 0;
        }
        return '<span class="badge bg-secondary">'.$reviewsApproved.' reviews</span>';
    }
}
