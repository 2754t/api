<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Password;

use App\Models\Player;
use App\Services\Exceptions\PlayerNotFoundException;
use App\Services\Exceptions\TokenHasExpiredException;
use App\Services\Exceptions\UrlInvalidException;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public function __invoke(string|null $token, string $password): void
    {
        if (!$token) {
            throw new UrlInvalidException('URLが正しくありません。');
        }

        $player = Player::where('password_token', $token)->first();

        if (!$player) {
            throw new PlayerNotFoundException('パスワード再設定の期限が切れているか、既に再設定済です。');
        }

        if (!$player->password_token_expired || $player->password_token_expired->lt(now())) {
            throw new TokenHasExpiredException('パスワード再設定の期限が切れているか、既に再設定済です。');
        }

        // 更新
        $player->password = Hash::make($password);
        $player->password_token = null;
        $player->password_token_expired = null;
        $player->save();
    }
}
