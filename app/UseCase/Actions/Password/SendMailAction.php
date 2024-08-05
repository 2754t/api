<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Password;

use App\Models\Team;
use App\Models\Player;
use App\Notifications\PasswordReminder;
use App\Services\Exceptions\PlayerNotFoundException;
use App\Services\Exceptions\TeamNotFoundException;
use App\Utilities\FrontUrlUtility;
use App\Utilities\SendMailUtility;

class SendMailAction
{
    public function __invoke(string $email): void
    {
        /** @var Team|null チーム取得 */
        $team = Team::query()
            // ->where('subdomain', $subdomain)
            ->first();
        if (!$team) {
            throw new TeamNotFoundException();
        }

        /** @var Player|null 選手取得 */
        $player = Player::query()
            ->where('team_id', $team->id)
            ->where('email', $email)
            ->first();
        if (!$player) {
            throw new PlayerNotFoundException();
        }

        // 選手更新
        $player->password_token = $this->generateFileToken();
        $player->password_token_expired = now()->addMinutes(30);
        $player->save();

        // 再設定メール送信
        $url = FrontUrlUtility::baseUrl($team->id) . '/password/reset/' . $player->password_token;
        $mail = new PasswordReminder($url);
        $mail_message = $mail->toMail($player);
        SendMailUtility::send($mail, $mail_message, $player);
    }

    // トークン生成
    private function generateFileToken(): string
    {
        while (true) {
            $bytes = openssl_random_pseudo_bytes(43);
            $generated = 'PasswordToken' . bin2hex($bytes);
            $exist = Player::where('password_token', $generated)->first();
            if ($exist === null) {
                return $generated;
            }
        }
    }
}
