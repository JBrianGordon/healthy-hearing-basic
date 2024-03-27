<?php
declare(strict_types=1);

namespace App\Enums\Model\Location;

enum LocationListingType: string
{
    case LISTING_TYPE_BASIC = 'Basic';
    case LISTING_TYPE_ENHANCED = 'Enhanced';
    case LISTING_TYPE_PREMIER = 'Premier';
    case LISTING_TYPE_NONE = 'None';

    public function getListingTypeLabel(): string
    {
        return match ($this) {
            self::LISTING_TYPE_BASIC => 'Basic',
            self::LISTING_TYPE_ENHANCED => 'Enhanced',
            self::LISTING_TYPE_PREMIER => 'Premier',
            self::LISTING_TYPE_NONE => 'None (not shown in directory)',
        };
    }
}


// static $preferredListingTypes = [self::LISTING_TYPE_ENHANCED, self::LISTING_TYPE_PREMIER];