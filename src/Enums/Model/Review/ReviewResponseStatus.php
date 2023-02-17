<?php

namespace App\Enums\Model\Review;

enum ReviewResponseStatus: int
{
    case RESPONSE_STATUS_NONE = 0;
    case RESPONSE_STATUS_RESPONDED = 1;
    case RESPONSE_STATUS_PUBLISHED = 2;
    case RESPONSE_STATUS_IGNORED = 3;

    public function getResponseStatusLabel(): string
    {
        return match ($this) {
            self::RESPONSE_STATUS_NONE => 'No Response',
            self::RESPONSE_STATUS_RESPONDED => 'Responded',
            self::RESPONSE_STATUS_PUBLISHED => 'Response Published',
            self::RESPONSE_STATUS_IGNORED => 'Response Ignored',
       };
    }
}