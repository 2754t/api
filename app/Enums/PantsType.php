<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * ユニフォームパンツタイプ
 */
enum PantsType: int
{
    use HasLabel;

    case SHORT = 1;
    case REGULAR = 2;
    case LONG = 3;
    case BONDS = 4;
    case SLIMLONG = 5;

    public function label(): string
    {
        return match ($this) {
            static::SHORT => "ショート",
            static::REGULAR => "レギュラー",
            static::LONG => "ロング",
            static::BONDS => "ボンズ",
            static::SLIMLONG => "スリムロング"
        };
    }
}
