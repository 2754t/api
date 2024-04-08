<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Notifications\AttendanceRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendAttendanceRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-attendance-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 次回送信日時が過去の活動を取得
        $activities = Activity::where('next_send_datetime', '<', now())->get();

        $activities->each(function (Activity $activity) {
            // 募集人数に足りているか
            if ($this->hasEnoughMember($activity)) {
                // todo 次回送信日をNullに
                return true;
            }

            // 助っ人以外で未送信の人が残っているか
            if ($this->hasUnsentMember($activity)) {
                $this->sendToMember($activity);
                $this->setNextSendDatetime($activity);
                return true;
            }

            // 助っ人で未送信の人が残っているか
            if ($this->hasUnsentHelper($activity)) {
                $this->sendToHelper($activity);
                $this->setNextSendDatetime($activity);
                return true;
            }

            // todo 次回送信日をNullに
            $this->sendToAdmin($activity);
        });
    }

    private function hasEnoughMember(Activity $activity)
    {
        // todo
        return false;
    }

    private function hasUnsentMember(Activity $activity)
    {
        // todo
        return true;
    }

    private function sendToMember(Activity $activity)
    {
        // メール送信
        // $player->notify(new AttendanceRequest($activity));

        // attendance 追加
    }

    private function hasUnsentHelper(Activity $activity)
    {
        // todo
        return true;
    }

    private function sendToHelper(Activity $activity)
    {
        // メール送信

        // attendance 追加
    }

    private function sendToAdmin(Activity $activity)
    {
    }

    private function setNextSendDatetime(Activity $activity)
    {
        // 初回の場合は3日後
        // そうでなければ2時間後
        // ただし、活動日を超えてしまう場合はNull
    }
}
