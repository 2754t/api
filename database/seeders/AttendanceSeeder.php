<?php

namespace Database\Seeders;

use App\Enums\Answer;
use App\Models\Attendance;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::query()->delete();

        $team_id = Team::where('team_name', 'Navies')->first()->id;

        $player_ids = Player::query()
            ->whereIn('nickname', ['舩越', '西久保', '山岸謙', '竹添', '井岡', '村井', '上利', '柏原', '横地', '緒方'])
            ->pluck('id');

        foreach ($player_ids as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 3;
            $attendance->answer = Answer::YES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        $player_ids2 = Player::query()
            ->whereIn('nickname', ['舩越', '西久保', '八代谷', '清水', '雅', '緒方', '池尾', '坂本', '上利', '岡本'])
            ->pluck('id');

        foreach ($player_ids2 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 4;
            $attendance->answer = Answer::YES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        $player_ids3 = Player::query()
            ->whereIn('nickname', ['舩越', '山岸', '西本', '矢口', '山岸謙'])
            ->pluck('id');

        foreach ($player_ids3 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 5;
            $attendance->answer = Answer::YES;
            $attendance->dh_flag = false;
            $attendance->save();
        };
    }
}
