<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * 出欠回答
 */
enum Answer: int
{
    use HasLabel;

    case NOANSWER = 0;
    case YES = 1;
    case NO = 2;
    case DUEDATE = 3;

    public function label(): string
    {
        return match ($this) {
            self::NOANSWER => '未回答',
            self::YES => '出席',
            self::NO => '欠席',
            self::DUEDATE => '期日指定',
        };
    }
}
