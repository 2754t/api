<?php

namespace App\Services;

use App\Enums\Answer;
use App\Enums\Position;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\StartingMember;
use Illuminate\Support\Collection;

class StartingMemberService
{
    /**
     * Undocumented function
     * 
     * 出席メンバーのうち、10人をスタメン (starting_lineup = true) にする
     * 残りをベンチ (starting_lineup = false) にする
     * スタメンのうち、ピッチャーができる人 (Player::pitcher_flag = true) のいずれかひとりを
     * ピッチャー (position = Position::PITCHER) にする。
     * スタメンのうち、キャッチャーができる人 (Player::catcher_flag = true) のいずれかひとりを
     * キャッチャー (position = Position::CATCHER) にする。
     * 残りの8人に、残りの8つのポジションを、ユニーク割り当てる
     * スタメンの10人に、1〜10 の打順をユニークに割り当てる
     *
     * @param Activity $activity
     * @return Collection<StartingMember>
     */
    public function generate(Activity $activity): Collection
    {
        $attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        $position_array = Position::cases();

        // Attendanceにplayerをリレーション
        // 取得したplayerがpitcher_flagを持っていたら
        // 出席者のうちピッチャーができる人を絞り込む
        $pitcher_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->pitcher_flag);
        $pitcher = $pitcher_attendances->random();

        return $attendances->map(function (Attendance $attendance) use ($position_array): StartingMember {
            $starting_member = new StartingMember();
            $starting_member->team_id = $attendance->team_id;
            $starting_member->player_id = $attendance->player_id;
            $starting_member->activity_id = $attendance->activity_id;
            $starting_member->attendance_id = $attendance->id;
            $starting_member->starting_lineup = "";
            $starting_member->position = "";
            $starting_member->batting_order = null;
            $starting_member->save();

            return $starting_member;
        });
    }
}