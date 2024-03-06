<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Shared\HasLabel;

/**
 * DHタイプ
 */
enum DHType: int
{
    use HasLabel;

    case ZERO = 0;
    case ONE = 1;
    case UNLIMITED = 2;

    public function label(): string
    {
        return match ($this) {
            self::ZERO => 'DHなし',
            self::ONE => 'DH一人',
            self::UNLIMITED => 'DH複数',
        };
    }
}
