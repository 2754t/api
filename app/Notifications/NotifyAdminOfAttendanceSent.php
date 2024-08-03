<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminOfAttendanceSent extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Activity $activity)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('出欠依頼を全員に送りました')
            ->line(sprintf(
                '%sの%sが登録されました。',
                $this->activity->activity_datetime->format('m月d日 H:i'),
                $this->activity->activity_type->label()
            ))
            ->line('サイトにアクセスして出欠を確認してください。')
            ->action('活動一覧ページ', url('/activity'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
