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
    private $position_array = [];
    private $batting_order_array = [];
    private $starting_members;

    public function generate(Activity $activity): void
    {
        $attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        // TODO DHを除く配列にしたい
        /** @var array<Position> */
        $this->position_array = Position::cases();
        // TODO activityテーブルにスタメン人数のカラムを追加。13のところをスタメン人数にする。
        // スタメン人数より多かったり少なかったりする場合は
        $this->batting_order_array = range(1,13);
        $this->starting_members = collect([]);

        // TODO ピッチャーキャッチャーいなかった時

        // 出席者のうちピッチャーができる人たち
        $pitcher_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->pitcher_flag);

        /** @var Attendance この試合のピッチャー */
        $pitcher_attendance = $pitcher_attendances->random();
        // まずスターティングメンバーにピッチャーを追加
        $starting_member = $this->createStartingMember($pitcher_attendance, Position::PITCHER);
        $this->starting_members->push($starting_member);

        // 残りの出席者のうちキャッチャーのできる人たち
        $catcher_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->catcher_flag && $attendance->id !== $this->starting_members->first()->attendance_id);
        /** @var Attendance この試合のピッチャー */
        $catcher_attendance = $catcher_attendances->random();
        // 2人目のスターティングメンバーにキャッチャーを追加
        $starting_member = $this->createStartingMember($catcher_attendance, Position::CATCHER);
        $this->starting_members->push($starting_member);

        $attendances = $attendances->filter(fn (Attendance $attendance) => !$this->starting_members->pluck('attendance_id')->contains($attendance->id));

        $attendances->each(function (Attendance $attendance): void {
            
            $starting_member = $this->createStartingMember($attendance);
            $this->starting_members->push($starting_member);
        });

        $this->starting_members->map(function (StartingMember $starting_member) {
            var_dump($starting_member->batting_order. "番 ". $starting_member->position->label(). " ". $starting_member->player->last_name);
        });
    }

    private function createStartingMember(Attendance $attendance, ?Position $position=null): StartingMember
    {
        $starting_member = new StartingMember();
        $starting_member->team_id = $attendance->team_id;
        $starting_member->player_id = $attendance->player_id;
        $starting_member->activity_id = $attendance->activity_id;
        $starting_member->attendance_id = $attendance->id;
        $starting_member->starting_lineup = YesNo::YES;
        $starting_member->position = $position? $position : $this->randPosition();
        $starting_member->batting_order = $this->batting_order_array[array_rand($this->batting_order_array)];

        
        if ($starting_member->position) {
            $this->position_array = array_filter($this->position_array, fn (Position $position) => $position !== $starting_member->position);
        }

        if ($starting_member->batting_order) {
            $this->batting_order_array = array_diff($this->batting_order_array, [$starting_member->batting_order]);
        }
        
        return $starting_member;
    }

    private function randPosition(): Position
    {
        if ($this->position_array === []) {
            return Position::DH;
        }

        return $this->position_array[array_rand($this->position_array, 1)];
    }
}
