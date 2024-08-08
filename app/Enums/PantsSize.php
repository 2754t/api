<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * ユニフォームパンツサイズ
 */
enum PantsSize: int
{
    use HasLabel;

    case S = 72;
    case M = 78;
    case L = 82;
    case O = 86;
    case XO = 89;
    case X6 = 95;
    case X8 = 105;
    case W110 = 110;
    case W115 = 115;
    case W120 = 120;
    case W125 = 125;
    case W130 = 130;
    case W135 = 135;

    public function label(): string
    {
        return match ($this) {
            static::S => "S",
            static::M => "M",
            static::L => "L",
            static::O => "O",
            static::XO => "XO",
            static::X6 => "X6",
            static::X8 => "X8",
            static::W110 => "W110",
            static::W115 => "W115",
            static::W120 => "W120",
            static::W125 => "W125",
            static::W130 => "W130",
            static::W135 => "W135"
        };
    }
}
