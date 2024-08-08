<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * ユニフォームシャツサイズ
 */
enum ShirtSize: int
{
    use HasLabel;

    case S = 88;
    case M = 92;
    case L = 96;
    case O = 100;
    case XO = 104;
    case XA = 108;
    case XXA = 112;
    case XXB = 116;
    case B122 = 122;
    case B128 = 128;
    case B134 = 134;
    case B140 = 140;

    public function label(): string
    {
        return match ($this) {
            static::S => "S",
            static::M => "M",
            static::L => "L",
            static::O => "O",
            static::XO => "XO",
            static::XA => "XA",
            static::XXA => "XXA",
            static::XXB => "XXB",
            static::B122 => "B122",
            static::B128 => "B128",
            static::B134 => "B134",
            static::B140 => "B140"
        };
    }
}
