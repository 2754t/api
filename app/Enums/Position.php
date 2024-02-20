<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * 守備位置
 */
enum Position: int
{
    use HasLabel;

    case PITCHER = 1;
    case CATCHER = 2;
    case FIRST = 3;
    case SECOND = 4;
    case THIRD = 5;
    case SHORT = 6;
    case LEFT = 7;
    case CENTER = 8;
    case RIGHT = 9;
    case DH = 10;    

    public function label(): string
    {
        return match ($this) {
            self::PITCHER => '投手',
            self::CATCHER => '捕手',
            self::FIRST => '一塁手',
            self::SECOND => '二塁手',
            self::THIRD => '三塁手',
            self::SHORT => '遊撃手',
            self::LEFT => '左翼手',
            self::CENTER => '中堅手',
            self::RIGHT => '右翼手',
            self::DH => '指名打者',
        };
    }
}
