<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * YesNo
 */
enum YesNo: int
{
    use HasLabel;

    case NO = 0;
    case YES = 1;  

    public function label(): string
    {
        return match ($this) {
            self::NO => 'No',
            self::YES => 'Yes',
        };
    }
}
