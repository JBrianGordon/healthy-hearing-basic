<?php
declare(strict_types=1);

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

    public static function getStatusLabelArray(): array
    {
        return array_map(fn($case) => $case->getStatusLabel(), self::cases());
    }

    public function getEditStatusLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Published',
            self::DENIED => 'Published Negative',
            self::RESPONDED => 'Responded',
            self::IGNORED => 'Ignored',
        };
    }

    public static function getEditStatusLabelArray(): array
    {
        return array_map(fn($case) => $case->getEditStatusLabel(), self::cases());
    }
}
