<?php

declare(strict_types=1);

namespace App\Utilities;

use Illuminate\Support\Str;

/**
 * パスワード
 */
class PasswordUtility
{
    // 一時パスワード生成
    public static function makeTemporaryPassword(): string
    {
        while (true) {
            $password = Str::random(12);

            if (preg_match('/^[0-9]*$/', $password)) {
                continue;
            }
            if (preg_match('/^[a-zA-Z]*$/', $password)) {
                continue;
            }

            return $password;
        }
    }
}
