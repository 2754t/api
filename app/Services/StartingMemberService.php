<?php

namespace App\Services;

use App\Enums\Answer;
use App\Enums\DHType;
use App\Enums\Position;
use App\Enums\YesNo;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\StartingMember;
use App\Services\Exceptions\NoCatcherException;
use App\Services\Exceptions\NoDHTypeException;
use App\Services\Exceptions\NoPitcherException;
use App\Services\Exceptions\NotEnoughMembersException;
use Illuminate\Support\Collection;

class StartingMemberService
{
    /** @var array<Position> DHを除くポジションの配列が初期値 */
    private $position_array = [];
    /** @var array<int> 出席者数までの数字の配列が初期値 */
    private $batting_order_array = [];
    /** @var Collection<StartingMember> ランダムで決まったスタメンのコレクション。空のコレクションが初期値 */
    private $starting_members;
    /** @var Activity 活動オブジェクト */
    private $activity;
    /** @var bool DHが1人の時の判定用 */
    private $first_call = true;

    public function generate(Activity $activity): Collection
    {
        if (!$activity->dh_type) {
            throw new NoDHTypeException('DHタイプが設定されていません。');
        }

        $attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        if ($attendances->count() < 9) {
            throw new NotEnoughMembersException('参加者が足りません。');
        }

        $this->position_array = array_filter(Position::cases(), fn($position) => $position !== Position::DH);
        $this->batting_order_array = range(1, $attendances->count());
        $this->starting_members = collect([]);
        $this->activity = $activity;

        $pitcher = $this->getPitcher($attendances);
        $this->starting_members->push($pitcher);

        $catcher = $this->getCatcher($attendances);
        $this->starting_members->push($catcher);

        $attendances = $attendances->filter(
            fn (Attendance $attendance) => !$this->starting_members->pluck('attendance_id')->contains($attendance->id)
        );

        $attendances->each(function (Attendance $attendance): void
        {
            $starting_member = $this->createStartingMember($attendance);
            $this->starting_members->push($starting_member);
        });

        // 打順で並び替え
        $this->starting_members = $this->starting_members->sortBy(fn (StartingMember $starting_member) => $starting_member->batting_order);

        $this->starting_members->map(function (StartingMember $starting_member) {
            var_dump($starting_member->batting_order. "番 ". $starting_member->position->label(). " ". $starting_member->player->last_name);
        });

        return $this->starting_members;
    }

    /**
     * @param Collection<Attendance> $attendances
     * @return StartingMember
     */
    private function getPitcher(Collection $attendances): StartingMember
    {
        // 出席者のうちピッチャーができる人たち
        $pitcher_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->pitcher_flag);

        if ($pitcher_attendances->isEmpty()) {
            throw new NoPitcherException('出席者にピッチャーがいません。');
        }

        /** @var Attendance この試合のピッチャー */
        $pitcher_attendance = $pitcher_attendances->random();

        return $this->createStartingMember($pitcher_attendance, Position::PITCHER);
    }

    /**
     * @param Collection<Attendance> $attendances
     * @return StartingMember
     */
    private function getCatcher(Collection $attendances): StartingMember
    {
        // 残りの出席者のうちキャッチャーのできる人たち
        $catcher_attendances = $attendances->filter(
            fn (Attendance $attendance) => $attendance->player->catcher_flag && $attendance->id !== $this->starting_members->first()->attendance_id
        );

        if ($catcher_attendances->isEmpty()) {
            throw new NoCatcherException('出席者にキャッチャーがいません。');
        }

        /** @var Attendance この試合のキャッチャー */
        $catcher_attendance = $catcher_attendances->random();

        return $this->createStartingMember($catcher_attendance, Position::CATCHER);
    }

    private function createStartingMember(Attendance $attendance, ?Position $position=null): StartingMember
    {
        $starting_member = new StartingMember();
        $starting_member->team_id = $attendance->team_id;
        $starting_member->player_id = $attendance->player_id;
        $starting_member->activity_id = $attendance->activity_id;
        $starting_member->attendance_id = $attendance->id;
        $starting_member->starting_lineup = $this->randPosition() ? YesNo::YES : YesNo::NO;
        $starting_member->position = $position ? $position : $this->randPosition();
        $starting_member->batting_order = $this->batting_order_array[array_rand($this->batting_order_array)];

        
        if ($starting_member->position) {
            $this->position_array = array_filter($this->position_array, fn (Position $position) => $position !== $starting_member->position);
        }

        if ($starting_member->batting_order) {
            $this->batting_order_array = array_diff($this->batting_order_array, [$starting_member->batting_order]);
        }
        
        return $starting_member;
    }

    private function randPosition(): ?Position
    {
        if ($this->activity->dh_type === DHType::ZERO && $this->position_array === []) {
            return null;
        }

        if ($this->activity->dh_type === DHType::ONE && $this->position_array === []) {
            return $this->first_call ? Position::DH :null;
        }

        if ($this->activity->dh_type === DHType::UNLIMITED && $this->position_array === []) {
            return Position::DH;
        }

        return $this->position_array[array_rand($this->position_array, 1)];
    }
}
