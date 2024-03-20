<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * 権限
 */
enum Role: int
{
    use HasLabel;

    case EXPERIENCE = 0;
    case HELPER = 1;
    case MEMBER = 2;
    case ADMIN = 3;

    public function label(): string
    {
        return match ($this) {
            self::EXPERIENCE => '体験者',
            self::HELPER => '助っ人',
            self::MEMBER => 'メンバー',
            self::ADMIN => '管理者',
        };
    }
}
