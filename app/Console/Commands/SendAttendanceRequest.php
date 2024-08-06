<?php

namespace App\Console\Commands;

use App\Enums\Answer;
use App\Enums\Role;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Player;
use App\Notifications\AttendanceRequest;
use App\Notifications\NotifyAdminOfAttendanceSent;
use App\Utilities\SendMailUtility;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

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
        // 活動日が未来で次回送信日時が過去の活動を取得
        $activities = Activity::query()
            ->where('activity_datetime', '>', now())
            ->where('next_send_datetime', '<', now())
            ->get();

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
                $this->setNextSendDatetime($activity);
                return true;
            }

            // メールを送る助っ人を絞る
            $helpers = $this->fetchUnsentHelper($activity);
            if ($helpers->isNotEmpty()) {
                $this->sendToPlayers($activity, $helpers);
                $this->setNextSendDatetime($activity);
                return true;
            }

            // 次回送信日をnullに
            $activity->next_send_datetime = null;
            $activity->save();
            $this->sendToAdmin($activity);
        });
    }

    /**
     * 残りの募集人数を取得
     *
     * @param Activity $activity
     * @return integer
     */
    private function countShortPlayer(Activity $activity): int
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

    /**
     * メールを送る管理者またはメンバーを取得
     *
     * @param Activity $activity
     * @param integer $short_player_count
     * @return Collection<Player>
     */
    private function fetchUnsentPlayers(Activity $activity, int $short_player_count): Collection
    {
        // 初回に募集する時
        if ($activity->recruitment === $short_player_count) {
            return $this->firstRecruitment($activity);
        }

        $builder = Attendance::query()
            ->where('activity_id', $activity->id)
            ->select('player_id');

        return Player::query()
            ->with('attendances')
            ->where('team_id', $activity->team_id)
            ->whereNotIn('id', $builder)
            ->where('role', Role::MEMBER)
            ->orderByDesc('attendance_priority')
            ->limit($short_player_count)
            ->get();
    }

    /**
     * 管理者または出席優先度の高いメンバーを募集人数取得
     *
     * @param Activity $activity
     * @return Collection<Player>
     */
    private function firstRecruitment(Activity $activity): Collection
    {
        $builder = Attendance::query()
            ->where('activity_id', $activity->id)
            ->select('player_id');

        /** @var Collection<Player> */
        $admins = Player::query()
            ->with('attendances')
            ->where('team_id', $activity->team_id)
            ->whereNotIn('id', $builder)
            ->where('role', Role::ADMIN)
            ->get();

        if ($admins->count() >= $activity->recruitment) {
            return $admins;
        }

        $limit_count = $activity->recruitment - $admins->count();

        /** @var Collection<Player> */
        $batteries = Player::query()
            ->with('attendances')
            ->where('team_id', $activity->team_id)
            ->where('role', Role::MEMBER)
            ->where(function ($query) {
                $query->where('pitcher_flag', true)
                    ->orWhere('catcher_flag', true);
            })
            ->whereNotIn('id', $builder)
            ->orderByDesc('attendance_priority')
            ->limit($limit_count)
            ->get();

        $admin_and_batteries = $admins->concat($batteries);

        if ($admin_and_batteries->count() >= $activity->recruitment) {
            return $admin_and_batteries;
        }

        $limit_count = $activity->recruitment - $admin_and_batteries->count();

        /** @var Collection<Player> */
        $member = Player::query()
            ->with('attendances')
            ->where('team_id', $activity->team_id)
            ->where('role', Role::MEMBER)
            ->whereNotIn('id', $builder)
            ->whereNotIn('id', $admin_and_batteries->pluck('id'))
            ->orderByDesc('attendance_priority')
            ->limit($limit_count)
            ->get();

        return $admin_and_batteries->concat($member);
    }

    /**
     * 出欠回答依頼メールを送り、出席優先度更新 出欠レコード作成
     *
     * @param Activity $activity
     * @param Collection<Player> $players
     * @return void
     */
    private function sendToPlayers(Activity $activity, Collection $players): void
    {
        // メール送信
        $players->each(function (Player $player) use ($activity) {
            $mail = new AttendanceRequest($activity);
            $mail_message = $mail->toMail($player);
            SendMailUtility::send($mail, $mail_message, $player);

            // playerの出席優先度更新
            $attendance_answer_and_penalties = $player->attendances()
                ->orderByDesc('id')
                ->limit(10)
                ->select('answer', 'penalty')
                ->get();
            if ($attendance_answer_and_penalties->count() > 0) {
                $attendance_priority = round((
                    $attendance_answer_and_penalties->whereIn('answer', [Answer::YES, Answer::CONDITIONALYES])->count() -
                    $attendance_answer_and_penalties->where('answer', Answer::NOANSWER)->count() -
                    $attendance_answer_and_penalties->sum('penalty')
                ) / $attendance_answer_and_penalties->count() * 100);
                $player->attendance_priority = $attendance_priority;
                $player->save();
            }

            // attendance追加
            $attendance = new Attendance();
            $attendance->team_id = $player->team_id;
            $attendance->activity_id = $activity->id;
            $attendance->player_id = $player->id;
            $attendance->dh_flag = false;
            $attendance->save();
        });
    }

    /**
     * 出席優先度の高い助っ人を2名取得
     *
     * @param Activity $activity
     * @return Collection<Player>
     */
    private function fetchUnsentHelper(Activity $activity): Collection
    {
        $builder = Attendance::query()
            ->where('activity_id', $activity->id)
            ->select('player_id');

        return Player::query()
            ->with('attendances')
            ->where('team_id', $activity->team_id)
            ->whereNotIn('id', $builder)
            ->where('role', Role::HELPER)
            ->orderByDesc('attendance_priority')
            ->limit(2)
            ->get();
    }

    private function sendToAdmin(Activity $activity)
    {
        $admins = Player::query()
            ->where('team_id', $activity->team_id)
            ->where('role', Role::ADMIN)
            ->get();

        $admins->each(function (Player $admin) use ($activity) {
            $mail = new NotifyAdminOfAttendanceSent($activity);
            $mail_message = $mail->toMail($admin);
            SendMailUtility::send($mail, $mail_message, $admin);
        });
    }

    private function setNextSendDatetime(Activity $activity): void
    {

        // 活動日まで2週間以内の時
        $activity->next_send_datetime = now()->addMinute(30);
        if (
            now()->addWeek(2) < $activity->activity_datetime &&
            $activity->activity_datetime <= now()->addWeek(3)
        ) {
            // 活動日まで2週間より前 かつ 3週間以内の時
            $activity->next_send_datetime = now()->addHour(2);
        } elseif (now()->addWeek(3) < $activity->activity_datetime) {
            // 活動日まで3週間より前の時
            $activity->next_send_datetime = now()->addDay(2);
        } else {
        }

        // 時間を9:00から18:00までに調整
        if ($activity->next_send_datetime->hour < 9) {
            $activity->next_send_datetime->setTime(9, 0);
        } elseif ($activity->next_send_datetime->hour >= 18) {
            $activity->next_send_datetime->addDay()->setTime(9, 0);
        }

        // メール送信するのは活動日の前日まで
        if ($activity->next_send_datetime->addDay() > $activity->activity_datetime) {
            $activity->next_send_datetime = null;
        }

        $activity->save();
    }
}
