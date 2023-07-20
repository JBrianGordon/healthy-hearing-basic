<?php
declare(strict_types=1);

namespace App\Enums\Model\Review;

enum ReviewRating: int
{
    case POOR = 1;
    case BELOW_AVERAGE = 2;
    case AVERAGE = 3;
    case ABOVE_AVERAGE = 4;
    case EXCELLENT = 5;

    public function getRatingLabel(): string
    {
        return match ($this) {
            self::POOR => '1 (Poor)',
            self::BELOW_AVERAGE => '2 (Below average)',
            self::AVERAGE => '3 (Average)',
            self::ABOVE_AVERAGE => '4 (Above average)',
            self::EXCELLENT => '5 (Excellent)',
        };
    }

    public static function getRatingValueArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function getRatingLabelArray(): array
    {
        return array_map(fn($case) => $case->getRatingLabel(), self::cases());
    }
}
