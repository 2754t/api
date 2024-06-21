<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * 審判の種類
 */
enum RefereeType: int
{
    use HasLabel;

    case DISPATCH = 1;
    case OURSELVES = 2;

    public function label(): string
    {
        return match ($this) {
            self::DISPATCH => '派遣審判',
            self::OURSELVES => '攻撃チームの選手',
        };
    }
}
