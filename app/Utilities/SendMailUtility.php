<?php

declare(strict_types=1);

namespace App\Utilities;

use App\Models\Player;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as NotificationFacade;

/**
 * メール送信
 */
class SendMailUtility
{
    public static function send(
        Notification $notification,
        MailMessage $mail_message,
        Player $to,
    ): void {

        // 本番以外ではログに出力
        if (config('app.env') !== 'production') {
            Log::channel('mail')->debug('Sending email to: ' . $to->email);
            Log::channel('mail')->debug('Notification class: ' .  print_r($mail_message->toArray(), true));
        }

        // ローカル以外では送信
        if (config('app.env') !== 'local' && config('app.env') !== 'testing') {
            NotificationFacade::send($to, $notification);
        }
    }
}
