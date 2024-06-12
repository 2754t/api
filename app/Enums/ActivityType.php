<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * 活動内容
 */
enum ActivityType: int
{
    use HasLabel;

    case PRACTICE = 0;
    case GAME = 1;
    case INTRASQUADGAME = 2;

    public function label(): string
    {
        return match ($this) {
            self::PRACTICE => '練習',
            self::GAME => '試合',
            self::INTRASQUADGAME => '紅白戦',
        };
    }
}
