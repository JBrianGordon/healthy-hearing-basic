<?php

namespace App\Enums\Model\Review;

enum ReviewOrigin: int
{
    case ORIGIN_ONLINE = 0;
    case ORIGIN_PHONE = 1;
    case ORIGIN_MAIL = 2;

    public function getOriginLabel(): string
    {
        return match ($this) {
            self::ORIGIN_ONLINE => 'Online',
            self::ORIGIN_PHONE => 'Phone',
            self::ORIGIN_MAIL => 'Mail',
        };
    }
}