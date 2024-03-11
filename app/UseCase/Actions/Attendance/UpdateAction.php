<?php

declare(strict_types=1);

namespace App\UseCase\Actions\Attendance;

use App\Enums\Answer;
use App\Enums\Position;
use App\Enums\YesNo;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\StartingMember;
use App\Services\StartingMemberService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    private $position_array = [];

    public function __invoke(Activity $activity, StartingMemberService $service)
    {
        DB::transaction(function () use ($activity, $service) {

            // 投手、捕手、DHを除いたポジション配列
            $this->position_array = array_filter(Position::cases(), function($position){
                return 
                    $position !== Position::PITCHER && 
                    $position !== Position::CATCHER && 
                    $position !== Position::DH;
            });
            // スタメンコレクション
            $starting_members = $service->generate($activity);
            // スタメンから投手、捕手を除いたplayer_idのコレクション
            $starting_player_ids = $starting_members->whereIn('position', [Position::PITCHER, Position::CATCHER])->pluck('player_id');
            // TODO team_idとactivity_idで絞るトレートをつくる
            /** @var Collection<Attendance> */
            $can_player_attendances = Attendance::with('player')->where('answer', Answer::YES)->whereNotIn('player_id', $starting_player_ids)->where('dh_flag', YesNo::NO)->get();

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
                return count(explode(',', $can_player_attendance->player->positions)) >= 2;
            });
            
            // 残りの参加者のコレクション
            $can_player_posteriority_attendances = $can_player_attendances->whereNotIn('id', $can_player_priority_attendances->pluck('id'));
            
            // ポジション配列に希望ポジションがあればセット
            $can_player_priority_attendances->shuffle()->each(function ($can_player_priority_attendance) use ($can_player_posteriority_attendances) {
                $this->createSecondPosition($can_player_priority_attendance, Position::from($can_player_priority_attendance->player->desired_position));
                if (!$can_player_priority_attendance->second_position) {
                    $can_player_posteriority_attendances->push($can_player_priority_attendance);
                }
            });

            // ポジション配列から外野を除外
            $this->position_array = array_filter($this->position_array, function ($position) {
                return !in_array($position, [Position::LEFT, Position::CENTER, Position::RIGHT]);
            });

            $can_player_posteriority_attendances->shuffle()->each(function ($can_player_posteriority_attendance) {
                // TODO　カンマ区切りの文字列から一致するポジションがあれば返す。
                if (!$can_player_posteriority_attendance->player->positions) {
                    // TODO コレクションから除く
                }
                $player_position_array = explode(",", $can_player_posteriority_attendance->player->positions);
                var_dump($player_position_array);die();
                // $this->createSecondPosition($can_player_posteriority_attendance);
            });
            
            var_dump($this->position_array);die();



            // TODO 画面に表示できるようになれば4行消す
            $starting_members = $starting_members->sortBy(fn (StartingMember $starting_member) => $starting_member->batting_order);
            $starting_members->map(function (StartingMember $starting_member) {
                // var_dump($starting_member->batting_order. "番 ". $starting_member->position->label(). " ". $starting_member->player->last_name);
            });

            dd("ok");
        });
    }

    private function createSecondPosition(Attendance $attendance, ?Position $position=null): void
    {
        $attendance->second_position = $position ? $position : $this->randPosition();
        $attendance->save();

        if ($attendance->second_position) {
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