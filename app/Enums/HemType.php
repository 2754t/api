<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * ユニフォームパンツすそ
 */
enum HemType: int
{
    use HasLabel;

    case RUBBER = 1;
    case NORUBBER = 2;
    case HOOK = 3;

    public function label(): string
    {
        return match ($this) {
            static::RUBBER => "ゴム入り",
            static::NORUBBER => "ゴムなし",
            static::HOOK => "ひっかけ"
        };
    }
}
