<?php

declare(strict_types=1);

namespace App\UseCase\Actions\StartingMember;

use App\Enums\Position;
use App\Models\Activity;
use App\Models\StartingMember;
use App\Services\StartingMemberService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UpdateAction
{
    private StartingMemberService $service;
    /** @var array<Position> DH,投手,捕手を除くポジションの配列が初期値 */
    private $position_array = [];
    /** @var Collection<StartingMember> スタメンサービスクラスで生成されたコレクション */
    private $starting_members;
    /** @var Collection<StartingMember> 第二ポジションをセット可能な選手コレクション */
    private $can_second_position_players;

    public function __construct(StartingMemberService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Activity $activity)
    {
        DB::transaction(function () use ($activity) {

            $this->setProperties($activity);

            $this->decideSecondPitcher();
            $this->decideSecondPosition();

            // テスト用
            // $this->starting_members->each(function (StartingMember $starting_member) {
            //     if ($starting_member->second_position === null) {
            //         $second_position = "";
            //     } else {
            //         $second_position = $starting_member->second_position->label();
            //     }
            //     var_dump($starting_member->attendance->player->last_name . ' ' . $starting_member->position->label() . ' ' . $second_position);
            // });
            // die();

            $activity->decide_order_flag = true;
            $activity->save();
        });
    }

    private function setProperties(Activity $activity): void
    {
        $this->position_array = array_filter(Position::cases(), function ($position) {
            return
                $position !== Position::PITCHER &&
                $position !== Position::CATCHER &&
                $position !== Position::DH;
        });

        $this->starting_members = StartingMember::query()
            ->with('attendance.player')
            ->whereIn('id', $this->service->generate($activity)->pluck('id'))
            ->get();

        $this->can_second_position_players = $this->starting_members
            ->filter(function (StartingMember $starting_member) {
                return $this->starting_members
                    ->whereNotIn('position', [Position::PITCHER, Position::CATCHER])
                    ->where('dh_flag', false)
                    ->pluck('attendance_id')
                    ->search($starting_member->attendance_id);
            });
    }

    private function decideSecondPitcher(): void
    {
        $can_pitchers = $this->can_second_position_players
            ->filter(function (StartingMember $can_second_position_player) {
                return $can_second_position_player->attendance->player->pitcher_flag;
            });

        if (!$can_pitchers->isEmpty()) {
            // TODO 成績順にする？
            /** @var StartingMember */
            $pitcher = $can_pitchers->filter(function (StartingMember $pitcher) {
                return $pitcher->attendance->player->last_name === '上利';
            })->first();
            $this->createSecondPosition($pitcher, Position::PITCHER);
        }
    }

    private function decideSecondPosition(): void
    {
        $this->for4positionJoined();

        // ポジション配列から外野を除外
        $this->position_array = array_filter($this->position_array, function (Position $position) {
            return !in_array($position, [Position::LEFT, Position::CENTER, Position::RIGHT]);
        });

        $this->can_second_position_players
            ->shuffle()
            ->each(function (StartingMember $can_second_position_player) {
                if ($this->position_array === []) {
                    // ループ終了
                    return false;
                }
                if (!$can_second_position_player->attendance->player->position_joined) {
                    // 何もしない（continueと同じ）
                    return true;
                }
                // カンマ区切りの文字列を配列に変換
                /** @var array<int> */
                $player_position_array = explode(',', $can_second_position_player->attendance->player->position_joined);
                // ポジション配列と一致するポジションのみに絞る
                $player_position_array = array_filter($player_position_array, function (int $player_position) {
                    return in_array(Position::tryFrom($player_position), $this->position_array);
                });

                if ($player_position_array === []) {
                    return true;
                }
                // 残りのポジションの配列からランダムで第二ポジションにする
                $position_int = (int)$player_position_array[array_rand($player_position_array, 1)];
                $this->createSecondPosition($can_second_position_player, Position::tryFrom($position_int));
            });
    }

    /**
     * できるポジションが4つ以上ある選手から第二ポジションをセット
     *
     * @return void
     */
    private function for4positionJoined(): void
    {
        $can_second_position_players = $this->can_second_position_players
            ->filter(function ($can_second_position_player) {
                if (!$can_second_position_player->attendance->player->position_joined) {
                    return false;
                }
                return count(explode(',', $can_second_position_player->attendance->player->position_joined)) >= 4;
            });

        // ポジション配列に希望ポジションがあればセット
        $can_second_position_players
            ->shuffle()
            ->each(function (StartingMember $can_second_position_player) {
                /** @var Position|null */
                $desired_position = $can_second_position_player->attendance->player->desired_position;
                if (!$desired_position) {
                    // 何もしない（continueと同じ）
                    return true;
                }
                // 希望ポジションがポジション配列にあるか判定
                if (!in_array($desired_position, $this->position_array)) {
                    return true;
                }
                $this->createSecondPosition($can_second_position_player, $desired_position);
            });
    }

    private function createSecondPosition(StartingMember $starting_member, ?Position $position = null): void
    {
        $position = $position ?? $this->randPosition();
        $starting_member->second_position = $position;
        $starting_member->save();

        if ($starting_member->second_position) {
            $this->position_array = array_filter($this->position_array, fn (Position $position) => $position !== $starting_member->second_position);
        }

        // 第二ポジションセット可能選手を更新
        $this->can_second_position_players = $this->can_second_position_players
            ->whereNotIn('id', $starting_member->id);
    }

    private function randPosition(): ?Position
    {
        if ($this->position_array === []) {
            return null;
        }

        return $this->position_array[array_rand($this->position_array, 1)];
    }
}
