<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Attendance;

use App\Enums\Answer;
use App\Enums\Position;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\StartingMember;
use App\Services\Exceptions\AlreadyDecidedException;
use App\Services\StartingMemberService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    private StartingMemberService $service;
    private $position_array = [];

    public function __construct(StartingMemberService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Activity $activity)
    {
        if ($activity->is_order) {
            throw new AlreadyDecidedException('既にオーダーが決められています。');
        }

        DB::transaction(function () use ($activity) {

            // 投手、捕手、DHを除いたポジション配列
            $this->position_array = array_filter(Position::cases(), function ($position) {
                return
                    $position !== Position::PITCHER &&
                    $position !== Position::CATCHER &&
                    $position !== Position::DH;
            });
            // スタメンコレクション
            $starting_members = $this->service->generate($activity);
            // スタメンから投手、捕手を除いたplayer_idのコレクション
            $starting_player_ids = $starting_members->whereIn('position', [Position::PITCHER, Position::CATCHER])->pluck('player_id');
            /** @var Collection<Attendance> */
            $attendances = Attendance::with(['player', 'starting_member'])
                ->where('activity_id', $activity->id)
                ->where('answer', Answer::YES)
                ->get();
            $can_player_attendances = $attendances->whereNotIn('player_id', $starting_player_ids)->where('dh_flag', false);
            $can_pitcher_attendances = $can_player_attendances->filter(function (Attendance $can_player_attendance) {
                return $can_player_attendance->player->pitcher_flag;
            });

            // 2番手ピッチャーをセット
            if (!$can_pitcher_attendances->isEmpty()) {
                $pitcher_attendance = $can_pitcher_attendances->random();
                $this->createSecondPosition($pitcher_attendance, Position::PITCHER);
                $can_player_attendances = $can_player_attendances->filter(fn ($can_player_attendance) => $can_player_attendance->id !== $pitcher_attendance->id);
            }

            // できるポジションが3つ以上ある人のコレクション
            $can_player_priority_attendances = $can_player_attendances->filter(function ($can_player_attendance) {
                if (!$can_player_attendance->player->positions) {
                    return false;
                }
                return count(explode(',', $can_player_attendance->player->positions)) >= 4;
            });

            // 残りの参加者のコレクション
            $can_player_posteriority_attendances = $can_player_attendances->whereNotIn('id', $can_player_priority_attendances->pluck('id'));

            // ポジション配列に希望ポジションがあればセット
            $can_player_priority_attendances->shuffle()->each(function ($can_player_priority_attendance) use ($can_player_posteriority_attendances) {
                $desired_position = $can_player_priority_attendance->player->desired_position;
                if (!$desired_position) {
                    // 何もしない（continueと同じ）
                    return true;
                }
                // 希望ポジションがポジション配列にあるか判定
                if (!in_array($desired_position, $this->position_array)) {
                    $can_player_posteriority_attendances->push($can_player_priority_attendance);
                    return true;
                }
                $this->createSecondPosition($can_player_priority_attendance, $desired_position);
            });

            // ポジション配列から外野を除外
            $this->position_array = array_filter($this->position_array, function ($position) {
                return !in_array($position, [Position::LEFT, Position::CENTER, Position::RIGHT]);
            });

            $can_player_posteriority_attendances->shuffle()->each(function ($can_player_posteriority_attendance) {
                if ($this->position_array === []) {
                    // ループ終了
                    return false;
                }
                if (!$can_player_posteriority_attendance->player->positions) {
                    // 何もしない（continueと同じ）
                    return true;
                }
                // カンマ区切りの文字列を配列に変換
                /** @var array<int> */
                $player_position_array = explode(',', $can_player_posteriority_attendance->player->positions);
                // ポジション配列と一致するポジションのみに絞る
                $player_position_array = array_filter($player_position_array, function (int $player_position) {
                    return in_array(Position::tryFrom($player_position), $this->position_array);
                });

                if ($player_position_array === []) {
                    return true;
                }
                // 残りのポジションの配列からランダムで第二ポジションにする
                $position_int = (int)$player_position_array[array_rand($player_position_array, 1)];
                $this->createSecondPosition($can_player_posteriority_attendance, Position::tryFrom($position_int));
            });


            // テスト用
            // $attendances->each(function (Attendance $attendance) {
            //     if ($attendance->second_position === null) {
            //         $second_position = "";
            //     } else {
            //         $second_position = $attendance->second_position->label();
            //     }
            //     var_dump($attendance->player->last_name . ' ' . $attendance->starting_member->position->label() . ' ' . $second_position);
            // });
            // die();

            $activity->is_order = true;
            $activity->save();
        });
    }

    private function createSecondPosition(Attendance $attendance, ?Position $position = null): void
    {
        $position = $position ?? $this->randPosition();
        $attendance->second_position = $position;
        $attendance->save();

        if ($position) {
            $this->position_array = array_filter($this->position_array, fn (Position $position) => $position !== $attendance->second_position);
        }
    }

    private function randPosition(): ?Position
    {
        if ($this->position_array === []) {
            return null;
        }

        return $this->position_array[array_rand($this->position_array, 1)];
    }
}
