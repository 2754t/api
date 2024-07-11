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

    public function __construct(Activity $activity)
    {
        $this->setProperties($activity);
    }

    public function generate(): Collection
    {
        $this->checkException();

        // ピッチャーを決める。ピッチャーの時打順下位にできるようにする。playerテーブルにカラム追加
        // キャッチャーを決める。
        // 体験者のポジション決める。
        // DHの人を打順先頭にする
        // 残りの参加者からスタメンを決める


        $pitcher = $this->getPitcher();
        $this->starting_members->push($pitcher);

        $catcher = $this->getCatcher();
        $this->starting_members->push($catcher);

        $this->attendances = $this->attendances->filter(
            fn (Attendance $attendance) => !$this->starting_members->pluck('attendance_id')->contains($attendance->id)
        );

        // $this->attendances = $this->attendances
        //     ->whereNotIn('id', )

        $experience_attendances = $this->attendances->filter(fn (Attendance $attendance) => $attendance->player->role === Role::EXPERIENCE);
        // 初回の体験者のみスタメンと希望ポジションが外野なら優遇（画面で制御のみ）
        $experience_attendances->each(function (Attendance $attendance) {
            $starting_member = $this->createStartingMember($attendance, $attendance->player->desired_position);
            $attendance->player->desired_position = null;
            $attendance->player->save();
            $this->starting_members->push($starting_member);
        });

        $this->attendances = $this->attendances
            ->whereNotIn('id', $experience_attendances->pluck('id'));

        // DHフラグのある出席者にポジションDHをセット（DHフラグを持てるかは出欠登録時にチェック）
        $dh_attendances = $this->attendances
            ->where('dh_flag', true)
            ->sortByDesc(fn (Attendance $attendance) => $attendance->dh_flag)
            ->each(function (Attendance $attendance): void {
                $starting_member = $this->createStartingMember($attendance, Position::DH);
                $this->starting_members->push($starting_member);
            });

        $this->attendances
            ->whereNotIn('id', $dh_attendances->pluck('id'))
            ->shuffle()
            ->each(function (Attendance $attendance): void {
                if ($attendance->player->pitcher_flag && ($this->starting_members->where('position', Position::DH)->count() + 9) < $this->attendances_count) {
                    $starting_member = $this->createStartingMember($attendance, Position::DH);
                    $this->starting_members->push($starting_member);
                } else {
                    $starting_member = $this->createStartingMember($attendance);
                }
            });


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
        } elseif ($this->activity->dh_type === DHType::ONE) {
            $this->batting_order_array = range(2, 10);
        } else {
            $this->batting_order_array = range(($this->attendances_count - 9), $this->attendances_count);
        }

        $this->starting_members = collect([]);

        $this->pitcher_attendances = $this->attendances
            ->filter(fn (Attendance $attendance) => $attendance->player->pitcher_flag);

        $this->catcher_attendances = $this->attendances
            ->filter(fn (Attendance $attendance) => $attendance->player->catcher_flag);
    }

    private function checkException(): void
    {
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
            throw new NotEnoughMembersBecauseManyDHsException('DH希望者が' . $this->attendances->where('DHFlag', true)->count() . '名のため、スタメンが決められません。');
        }

        if ($this->pitcher_attendances->count() <= 2) {
            throw new NoPitcherException('ピッチャーが足りません。');
        }

        if ($this->catcher_attendances->isEmpty()) {
            throw new NoCatcherException('キャッチャーがいません。');
        }
    }

    private function getPitcher(): StartingMember
    {



        // TODO ランダムではなく成績順にする
        /** @var Attendance この試合のピッチャー */
        $pitcher_attendance = $this->pitcher_attendances->random();

        return $this->createStartingMember($pitcher_attendance, Position::PITCHER);
    }

    /**
     * @param Collection<Attendance> $this->attendances
     * @return StartingMember
     */
    private function getCatcher(): StartingMember
    {
        // 残りの出席者のうちキャッチャーのできる人たち
        $catcher_attendances = $this->attendances->filter(
            fn (Attendance $attendance) => $attendance->player->catcher_flag && $attendance->id !== $this->starting_members->first()->attendance_id
        );



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
