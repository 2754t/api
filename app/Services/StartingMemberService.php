<?php

namespace App\Services;

use App\Enums\Answer;
use App\Enums\Position;
use App\Enums\YesNo;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\StartingMember;

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
     */
    public function generate(Activity $activity): void
    {
        $attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        /** @var array<Position> */
        $position_array = Position::cases();
        $starting_members = collect([]);

        // TODO ピッチャーキャッチャーいなかった時

        // 出席者のうちピッチャーができる人たち
        $pitcher_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->pitcher_flag);
        /** @var Attendance この試合のピッチャー */
        $pitcher_attendance = $pitcher_attendances->random();
        // まずスターティングメンバーにピッチャーを追加
        $starting_member = $this->createStartingMember($pitcher_attendance, $position_array, Position::PITCHER);
        $starting_members->push($starting_member);

        // 残りの出席者のうちキャッチャーのできる人たち
        $catcher_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->catcher_flag && $attendance->id !== $starting_members->first()->attendance_id);
        /** @var Attendance この試合のピッチャー */
        $catcher_attendance = $catcher_attendances->random();
        // 2人目のスターティングメンバーにキャッチャーを追加
        $starting_member = $this->createStartingMember($catcher_attendance, $position_array, Position::CATCHER);
        $starting_members->push($starting_member);

        $attendances = $attendances->filter(fn (Attendance $attendance) => !$starting_members->pluck('attendance_id')->contains($attendance->id));

        $attendances->map(function (Attendance $attendance) use (&$position_array, $starting_members): StartingMember {
            
            $starting_member = $this->createStartingMember($attendance, $position_array);
            $starting_members->push($starting_member);

            return $starting_member;
        });

        // $starting_members->sortBy(['position', 'desc']);
        $starting_members->map(function (StartingMember $starting_member) {
            var_dump($starting_member->position->label(). " ". $starting_member->player->last_name);
        });

        $starting_members = collect([]);
    }

    private function createStartingMember(Attendance $attendance, array &$position_array, ?Position $position=null): StartingMember
    {
        $starting_member = new StartingMember();
        $starting_member->team_id = $attendance->team_id;
        $starting_member->player_id = $attendance->player_id;
        $starting_member->activity_id = $attendance->activity_id;
        $starting_member->attendance_id = $attendance->id;
        $starting_member->starting_lineup = YesNo::YES;
        $starting_member->position = $position? $position : $this->randPosition($position_array);
        $starting_member->batting_order = null;

        
        if ($starting_member->position) {
            unset($position_array[$starting_member->position->value - 1]);
        }
        
        return $starting_member;
    }

    private function randPosition(array $position_array): Position
    {
        return $position_array[array_rand($position_array, 1)];
    }
}
