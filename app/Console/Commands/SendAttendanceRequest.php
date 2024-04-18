<?php

namespace App\Console\Commands;

use App\Enums\Answer;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Player;
use App\Notifications\AttendanceRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
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
            $short_member_count = $this->countShortPlayer($activity);
            if ($short_member_count === 0) {
                // 次回送信日をNullに
                $activity->next_send_datetime = null;
                $activity->save();
                return true;
            }

            // 助っ人以外で未送信の人が残っているか
            $players = $this->fetchUnsentPlayers($activity, $short_member_count);
            if ($players->isNotEmpty()) {
                $this->sendToPlayers($activity, $players);
                $this->setNextSendDatetime($activity, $players);
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

    private function countShortPlayer(Activity $activity)
    {
        // TODO 募集人数がnullの処理
        /** @var int */
        $attendances_count = Attendance::where('activity_id', $activity->id)->where('answer', Answer::YES)->count();
        if ($activity->recruitment <= $attendances_count) {
            return 0;
        }
        return $activity->recruitment - $attendances_count;
    }

    private function fetchUnsentPlayers(Activity $activity, int $short_member_count)
    {
        $builder = Attendance::where('activity_id', $activity->id)->select('player_id');

        return Player::whereNotIn('id', $builder)->limit($short_member_count)->get();
    }

    /**
     * Undocumented function
     *
     * @param Activity $activity
     * @param Collection<Player> $players
     * @return void
     */
    private function sendToPlayers(Activity $activity, Collection $players)
    {
        // メール送信
        $players->each(function (Player $player) use ($activity) {
            $player->notify(new AttendanceRequest($activity));

            // attendance 追加
            $attendance = new Attendance();
            $attendance->team_id = $player->team_id;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            // TODO デフォルト値変更
            $attendance->dh_flag = false;
            $attendance->save();
        });
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
        // if (!$activity->next_send_datetime)
        // そうでなければ2時間後
        // ただし、活動日を超えてしまう場合はNull
    }
}
