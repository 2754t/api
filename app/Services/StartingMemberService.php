<?php

namespace App\Services;

use App\Enums\ActivityType;
use App\Enums\Answer;
use App\Enums\DHType;
use App\Enums\Position;
use App\Enums\Role;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\StartingMember;
use App\Services\Exceptions\NoCatcherException;
use App\Services\Exceptions\NoPitcherException;
use App\Services\Exceptions\NotEnoughMembersException;
use DomainException;
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

    public function generate(Activity $activity): Collection
    {

        if ($activity->activity_type !== ActivityType::GAME) {
            throw new DomainException('試合ではありません。');
        }

        if (!$activity->dh_type) {
            throw new DomainException('DHタイプが未設定です。');
        }

        $attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $activity->id)
            ->where('answer', Answer::YES)
            ->get();

        if ($attendances->count() < 9) {
            throw new NotEnoughMembersException('参加者が足りません。');
        }

        $this->position_array = array_filter(Position::cases(), fn ($position) => $position !== Position::DH);

        if ($attendances->count() === 9 || $activity->dh_type === DHType::ZERO) {
            $this->batting_order_array = range(1, 9);
        } elseif ($activity->dh_type === DHType::ONE) {
            $this->batting_order_array = range(1, 10);
        } else {
            $this->batting_order_array = range(1, $attendances->count());
        }

        $this->starting_members = collect([]);
        $this->activity = $activity;

        $pitcher = $this->getPitcher($attendances);
        $this->starting_members->push($pitcher);

        $catcher = $this->getCatcher($attendances);
        $this->starting_members->push($catcher);

        $attendances = $attendances->filter(
            fn (Attendance $attendance) => !$this->starting_members->pluck('attendance_id')->contains($attendance->id)
        );

        $experience_attendances = $attendances->filter(fn (Attendance $attendance) => $attendance->player->role === Role::EXPERIENCE);
        // 初回の体験者のみスタメンと希望ポジションが外野なら優遇（画面で制御のみ）
        $experience_attendances->each(function (Attendance $attendance) {
            $starting_member = $this->createStartingMember($attendance, Position::tryFrom($attendance->player->desired_position));
            $attendance->player->desired_position = null;
            $attendance->player->save();
            $this->starting_members->push($starting_member);
        });


        $attendances->whereNotIn('id', $experience_attendances->pluck('id'))->each(function (Attendance $attendance): void {
            $starting_member = $this->createStartingMember($attendance);
            $this->starting_members->push($starting_member);
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

    private function createStartingMember(Attendance $attendance, ?Position $position = null): StartingMember
    {
        $starting_member = new StartingMember();
        $starting_member->team_id = $attendance->team_id;
        $starting_member->player_id = $attendance->player_id;
        $starting_member->activity_id = $attendance->activity_id;
        $starting_member->attendance_id = $attendance->id;
        $starting_member->position = $position ? $position : $this->randPosition();
        $starting_member->starting_lineup = $starting_member->position !== null;
        if ($starting_member->starting_lineup && $this->batting_order_array) {
            $starting_member->batting_order = $this->batting_order_array[array_rand($this->batting_order_array)];
        }

        if ($starting_member->position) {
            $this->position_array = array_filter($this->position_array, fn (Position $position) => $position !== $starting_member->position);
        }

        if ($starting_member->batting_order) {
            $this->batting_order_array = array_diff($this->batting_order_array, [$starting_member->batting_order]);
        }

        $starting_member->save();
        return $starting_member;
    }

    private function randPosition(): ?Position
    {
        if ($this->activity->dh_type === DHType::ZERO && $this->position_array === []) {
            return null;
        }

        if ($this->activity->dh_type === DHType::ONE && $this->position_array === []) {
            if ($this->starting_members->where('position', Position::DH)->count() > 0) {
                return null;
            } else {
                return Position::DH;
            }
        }

        if ($this->activity->dh_type === DHType::UNLIMITED && $this->position_array === []) {
            return Position::DH;
        }

        return $this->position_array[array_rand($this->position_array, 1)];
    }
}
