<?php

namespace App\Console\Commands;

use App\Enums\Answer;
use App\Enums\Role;
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
            $short_player_count = $this->countShortPlayer($activity);
            if ($short_player_count === 0) {
                // 次回送信日をnullに
                $activity->next_send_datetime = null;
                $activity->save();
                return true;
            }

            // メールを送る選手を絞る
            $players = $this->fetchUnsentPlayers($activity, $short_player_count);
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
        // 募集人数にしていがなければ
        if (!$activity->recruitment) {
            return 99999;
        }
        /** @var int */
        $attendances_count = Attendance::query()
            ->where('activity_id', $activity->id)
            ->whereIn('answer', [Answer::YES, Answer::CONDITIONALYES])
            ->count();

        if ($activity->recruitment <= $attendances_count) {
            return 0;
        }
        return (int)($activity->recruitment - $attendances_count);
    }

    private function fetchUnsentPlayers(Activity $activity, int $short_player_count)
    {
        // 初回に募集する時
        if ($activity->recruitment === $short_player_count) {
            /** @var Collection<Player> */
            $players = Player::query()
                ->where('role', Role::ADMIN)
                ->get();

            if ($players->count() >= $activity->recruitment) {
                return $players;
            }

            $limit_count = (int)($activity->recruitment - $players->count());

            // Player::query()
            //     ->where('role', Role::MEMBER)
            //     ->orderByDesc('a') 出席優先度
            //     ->limit($limit_count)
            //     ->get();

            return $players;
        }

        $builder = Attendance::query()
            ->where('activity_id', $activity->id)
            ->select('player_id');


        return Player::query()
            ->whereNotIn('id', $builder)
            ->whereIn('role', [Role::ADMIN, Role::MEMBER])
            ->limit($short_player_count)
            ->get();
    }

    /**
     * 管理者とメンバーに出欠回答依頼メールを送る
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

            // attendance追加
            $attendance = new Attendance();
            $attendance->team_id = $player->team_id;
            $attendance->activity_id = $activity->id;
            $attendance->player_id = $player->id;
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
        if (
            now()->addWeek(2) < $activity->activity_datetime &&
            $activity->activity_datetime <= now()->addWeek(3)
        ) {
            // 活動日まで2週間以上3週間未満であれば2時間置きに送る。8時から20時
            $activity->next_send_datetime = now()->addHour(2);
            $activity->save();
        } elseif (now()->addWeek(3) < $activity->activity_datetime) {
            // 活動日まで3週間以上あれば2日置きに送る。8時から20時
            $activity->next_send_datetime = now()->addDay(2);
            $activity->save();
        } else {
            // TODO
            $activity->next_send_datetime = now()->addMinute(15);
            $activity->save();
        }
    }
}
