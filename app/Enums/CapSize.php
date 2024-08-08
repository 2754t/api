<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * ユニフォーム帽子サイズ
 */
enum CapSize: int
{
    use HasLabel;

    case S = 54;
    case M = 56;
    case L = 58;
    case O = 60;
    case XO = 62;
    case XXO = 64;

    public function label(): string
    {
        return match ($this) {
            static::S => "S",
            static::M => "M",
            static::L => "L",
            static::O => "O",
            static::XO => "XO",
            static::XXO => "XXO(64)"
        };
    }
}
