<?php
declare(strict_types=1);

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

    public static function getOriginLabelArray(): array
    {
        return array_map(fn($case) => $case->getOriginLabel(), self::cases());
    }

    public function getOriginVerification(): string
    {
        return match ($this) {
            self::ORIGIN_ONLINE => 'Review submitted online',
            self::ORIGIN_PHONE => 'Review verified by phone',
            self::ORIGIN_MAIL => 'Review received via mail',
        };
    }
}
