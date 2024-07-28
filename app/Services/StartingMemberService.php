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
use App\Services\Exceptions\AlreadyDecidedException;
use App\Services\Exceptions\NoCatcherException;
use App\Services\Exceptions\NoPitcherException;
use App\Services\Exceptions\NotEnoughMembersBecauseManyDHsException;
use App\Services\Exceptions\NotEnoughMembersException;
use DomainException;
use Illuminate\Support\Collection;

class StartingMemberService
{
    /** @var Activity 対象の活動 */
    private $activity;
    /** @var Collection<Attendance> 参加者のコレクション */
    private $attendances;
    /** @var int|null 出席者数 */
    private $attendances_count = null;
    /** @var int|null DH数 */
    private $dh_count = null;
    /** @var array<Position> DHを除くポジションの配列が初期値 */
    private $position_array = [];
    /** @var array<int> 出席者数までの数字の配列が初期値 */
    private $batting_order_array = [];
    /** @var Collection<StartingMember> ランダムで決まったスタメンのコレクション。空のコレクションが初期値 */
    private $starting_members;
    /** @var Collection<Attendance> ピッチャーができる参加者のコレクション */
    private $pitcher_attendances;
    /** @var Collection<Attendance> キャッチャーができる参加者のコレクション */
    private $catcher_attendances;
    /** @var Collection<Attendance> DHの出席者コレクション */
    private $dh_attendances;

    public function generate(Activity $activity): Collection
    {
        $this->setProperties($activity);
        $this->checkException();

        $this->decidePitcher();
        $this->decideCatcher();
        $this->decideDH();
        $this->decideExperience();
        $this->decideStartingMember(); // 残りの参加者からスタメンを決める

        return $this->starting_members;
    }

    private function setProperties(Activity $activity): void
    {
        $this->activity = $activity;

        $this->attendances = Attendance::query()
            ->with('player')
            ->where('activity_id', $this->activity->id)
            ->where('answer', Answer::YES)
            ->get();

        $this->attendances_count = $this->attendances->count();

        $this->position_array = array_filter(Position::cases(), fn ($position) => $position !== Position::DH);

        if ($this->attendances_count === 9 || $this->activity->dh_type === DHType::ZERO) {
            $this->batting_order_array = range(1, 9);
            $this->dh_count = 0;
        } elseif ($this->activity->dh_type === DHType::ONE) {
            $this->batting_order_array = range(1, 10);
            $this->dh_count = 1;
        } else {
            $this->batting_order_array = range(1, $this->attendances_count);
            $this->dh_count = $this->attendances_count - 9;
        }

        $this->starting_members = collect([]);

        $this->pitcher_attendances = $this->attendances
            ->where('dh_flag', false)
            ->filter(fn (Attendance $attendance) => $attendance->player->pitcher_flag);

        $this->catcher_attendances = $this->attendances
            ->where('dh_flag', false)
            ->filter(fn (Attendance $attendance) => $attendance->player->catcher_flag);

        $this->dh_attendances = $this->attendances
            ->where('dh_flag', true);
    }

    private function checkException(): void
    {
        if ($this->activity->decide_order_flag) {
            throw new AlreadyDecidedException('既にオーダーが決められています。');
        }

        if ($this->activity->activity_type === ActivityType::PRACTICE) {
            throw new DomainException('試合ではありません。');
        }

        if (!$this->activity->dh_type) {
            throw new DomainException('DHタイプが未設定です。');
        }

        if ($this->attendances_count < 9) {
            throw new NotEnoughMembersException('参加者が足りません。');
        }

        if (($this->attendances_count - 9) < $this->attendances->where('dh_flag', true)->count()) {
            throw new NotEnoughMembersBecauseManyDHsException('DH希望者が' . $this->attendances->where('dh_flag', true)->count() . '名のため、スタメンが決められません。');
        }

        if ($this->pitcher_attendances->count() <= 2) {
            throw new NoPitcherException('ピッチャーが足りません。');
        }

        if ($this->catcher_attendances->isEmpty()) {
            throw new NoCatcherException('キャッチャーがいません。');
        }
    }

    private function decidePitcher(): void
    {
        // TODO 成績順にする
        /** @var Attendance */
        $pitcher_attendance = $this->pitcher_attendances
            ->whereNotIn('id', $this->dh_attendances->pluck('id'))
            ->where('player_id', 5)
            ->firstOrFail();


        $this->createStartingMember($pitcher_attendance, Position::PITCHER);
    }

    private function decideCatcher(): void
    {
        /** @var Attendance */
        $catcher_attendance = $this->catcher_attendances
            ->whereNotIn('id', $this->starting_members->pluck('attendance_id'))
            ->shuffle()
            ->firstOrFail();

        $this->createStartingMember($catcher_attendance, Position::CATCHER);
    }

    private function decideDH(): void
    {
        if ($this->dh_attendances->count() < $this->dh_count) {
            $additional_attendances = $this->attendances
                ->whereNotIn('id', $this->dh_attendances->pluck('id'))
                ->shuffle()
                ->take($this->dh_count - $this->dh_attendances->count());

            $this->dh_attendances = $this->dh_attendances->concat($additional_attendances);
        }

        $this->dh_attendances
            ->shuffle()
            ->each(function (Attendance $attendance): void {
                $this->createStartingMember($attendance, Position::DH);
            });
    }

    private function decideExperience(): void
    {
        $experience_attendances = $this->attendances
            ->filter(fn (Attendance $attendance) => $attendance->player->role === Role::EXPERIENCE);
        // 体験者のみスタメン かつ 初回のみ希望ポジションが外野なら優遇（画面でのみ制御）
        $experience_attendances->each(function (Attendance $attendance) {
            $this->createStartingMember($attendance, $attendance->player->desired_position);
            $attendance->player->desired_position = null;
            $attendance->player->save();
        });
    }

    private function decideStartingMember(): void
    {
        $this->attendances
            ->shuffle()
            ->each(function (Attendance $attendance): void {
                $this->createStartingMember($attendance);
            });
    }

    private function createStartingMember(Attendance $attendance, ?Position $position = null): void
    {
        $starting_member = new StartingMember();
        $starting_member->team_id = $attendance->team_id;
        $starting_member->attendance_id = $attendance->id;
        $starting_member->position = $position ?? $this->randPosition();
        if ($starting_member->position) {
            $this->position_array = array_filter($this->position_array, fn (Position $position) => $position !== $starting_member->position);
        }
        $starting_member->starting_flag = $starting_member->position !== null;
        $starting_member->batting_order = $starting_member->position ? $this->decideBattingOrder($attendance, $starting_member->position) : null;
        if ($starting_member->batting_order) {
            $this->batting_order_array = array_diff($this->batting_order_array, [$starting_member->batting_order]);
        }
        $starting_member->save();

        $this->starting_members->push($starting_member);
        // 出席者コレクションを更新
        $this->attendances = $this->attendances
            ->whereNotIn('id', $starting_member->attendance_id)
            ->values();;
    }

    private function randPosition(): ?Position
    {
        if ($this->position_array === []) {
            return null;
        }

        return $this->position_array[array_rand($this->position_array, 1)];
    }

    private function decideBattingOrder(Attendance $attendance, Position $position): int|null
    {

        if ($attendance->player->batting_order_bottom_flag && $position === Position::PITCHER) {
            // 先発ピッチャーが打順下位フラグを持っていれば打順7番以降
            $bottom_batting_order_array = array_diff($this->batting_order_array, range(1, 6));
            return $bottom_batting_order_array[array_rand($bottom_batting_order_array)];
        }

        if ($position === Position::PITCHER || $position === Position::CATCHER) {
            // スタメンの投手捕手をDHから除外するため、先に打順を決める
            $not_dh_batting_order_array = array_diff($this->batting_order_array, range(1, $this->dh_count));
            return $not_dh_batting_order_array[array_rand($not_dh_batting_order_array)];
        }

        if ($position === Position::DH) {
            // DHの時は打順先頭
            return $this->batting_order_array[array_key_first($this->batting_order_array)];
        }

        if ($this->batting_order_array) {
            return $this->batting_order_array[array_rand($this->batting_order_array)];
        }

        return null;
    }
}
