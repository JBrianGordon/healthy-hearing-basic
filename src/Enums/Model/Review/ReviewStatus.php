<?php

namespace App\Enums\Model\Review;

enum ReviewStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case DENIED = 2;
    case RESPONDED = 3;
    case IGNORED = 4;

    public function getStatusLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::DENIED => 'Denied',
            self::RESPONDED => 'Responded',
            self::IGNORED => 'Ignored',
        };
    }
}