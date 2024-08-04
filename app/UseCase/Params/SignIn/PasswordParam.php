<?php

declare(strict_types=1);

namespace App\UseCase\Params\SignIn;

use App\Shared\Param;

/**
 * @property string $current_password      現在のパスワード
 * @property string $password              新しいパスワード
 * @property string $password_confirmation 新しいパスワード（確認用）
 */
class PasswordParam extends Param
{
    protected $fillable = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $casts = [
        'current_password' => 'string',
        'password' => 'string',
        'password_confirmation' => 'string',
    ];
}
