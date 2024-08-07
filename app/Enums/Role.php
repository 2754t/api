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

    case ADMIN = 1;
    case MEMBER = 10;
    case HELPER = 20;
    case EXPERIENCE = 30;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => '管理者',
            self::MEMBER => 'メンバー',
            self::HELPER => '助っ人',
            self::EXPERIENCE => '体験者',
        };
    }
}
