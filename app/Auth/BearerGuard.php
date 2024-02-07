<?php

declare(strict_types=1);

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class BearerGuard implements Guard
{
    use GuardHelpers;

    protected string $token_key = 'access_token';
    protected string $expired_key = 'access_token_expired';
    protected Request $request;

    public function __construct(
        UserProvider $provider,
        Request $request,
    ) {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user(): ?Authenticatable
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $token = $this->getTokenForRequest();

        if (empty($token)) {
            return null;
        }

        $user = $this->provider->retrieveByCredentials([
            $this->token_key => $token,
        ]);

        // トークン切れ
        if ($user && $user->{$this->token_key} && $user->{$this->expired_key}->lte(now())) {
            return null;
        }

        $this->user = $user;

        return $user;
    }

    /**
     * @param array<string, mixed> $credentials
     */
    public function validate(array $credentials = []): bool
    {
        return false;
    }

    /**
     * トークンの取得
     *
     * ファイルAPIにはクエリストリングでトークンを送信するため、
     * Bearerトークンがなければクエリストリングを見る
     */
    public function getTokenForRequest(): ?string
    {
        if ($access_token = $this->request->bearerToken()) {
            return $access_token;
        }

        if ($access_token = $this->request->input('access_token')) {
            return $access_token;
        }

        return null;
    }
}
