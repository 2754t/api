<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * 登板評価
 */
enum PitchingEvaluation: int
{
    use HasLabel;

    case WIN = 1;
    case LOSS = 2;
    case HOLD = 3;
    case SAVE = 4;


    public function label(): string
    {
        return match ($this) {
            self::WIN => '勝',
            self::LOSS => '負',
            self::HOLD => 'ホールド',
            self::SAVE => 'セーブ',
        };
    }
}
