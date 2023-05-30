<?php
declare(strict_types=1);

namespace App\Enums\Model\Location;

enum LocationReviewStatus: string
{
    case REVIEW_STATUS_5_PLUS = 'Review5Plus';
    case REVIEW_STATUS_4_LESS = 'Review4Less';

    public function getStatusLabel(): string
    {
        return match ($this) {
            self::REVIEW_STATUS_5_PLUS => 'Review5Plus (5 or more active reviews)',
            self::REVIEW_STATUS_4_LESS => 'Review4Less (4 or less active reviews)',
        };
    }
}
