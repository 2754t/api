<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * ユニフォームシャツ袖丈
 */
enum SleeveType: int
{
    use HasLabel;

    case SHORT = 1;
    case NORMAL = 2;
    case BITLONG = 3;
    case LONG = 4;

    public function label(): string
    {
        return match ($this) {
            static::SHORT => "短め",
            static::NORMAL => "ノーマル",
            static::BITLONG => "やや長め",
            static::LONG => "長め"
        };
    }
}
