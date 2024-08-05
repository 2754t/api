<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Password;

use App\Models\Player;
use App\Services\Exceptions\TokenHasExpiredException;
use App\Services\Exceptions\UrlInvalidException;

class VerifyTokenAction
{
    public function __invoke(string $token): void
    {
        $player = Player::where('password_token', $token)->first();

        if (!$player) {
            throw new UrlInvalidException('URLが正しくありません。');
        }

        if (!$player->password_token_expired || $player->password_token_expired->lt(now())) {
            throw new TokenHasExpiredException('URlの有効期限が切れています。確認メールの送信からやり直して下さい。');
        }
    }
}
