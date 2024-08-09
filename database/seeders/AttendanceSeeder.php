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

        $player_ids4 = Player::query()
            ->whereIn('nickname', ['舩越', '西久保', '八代谷', '清水', '雅', '緒方', '池尾', '坂本', '上利', '岡本'])
            ->pluck('id');

        foreach ($player_ids4 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 4;
            $attendance->answer = Answer::YES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        $player_ids5 = Player::query()
            ->whereIn('nickname', ['舩越', '山岸', '西本', '矢口', '山岸謙', '雅', '清水', '柏原', '小島', '永井慎'])
            ->pluck('id');

        foreach ($player_ids5 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 5;
            $attendance->answer = Answer::YES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        // 8/17
        $player_ids6 = Player::query()
            ->whereIn('nickname', ['舩越', '山岸', '山岸謙', '雅', '田村', '西久保'])
            ->pluck('id');

        foreach ($player_ids6 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 6;
            $attendance->answer = Answer::CONDITIONALYES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        // 8/24
        $player_ids7 = Player::query()
            ->whereIn('nickname', ['舩越', '上利', '村井', '横地', '西久保', '清水'])
            ->pluck('id');

        foreach ($player_ids7 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 7;
            $attendance->answer = Answer::CONDITIONALYES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        // 8/31
        $player_ids8 = Player::query()
            ->whereIn('nickname', ['舩越', '西久保', '甲斐'])
            ->pluck('id');

        foreach ($player_ids8 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 8;
            $attendance->answer = Answer::CONDITIONALYES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        // 9/14
        $player_ids9 = Player::query()
            ->whereIn('nickname', ['舩越', '山岸'])
            ->pluck('id');

        foreach ($player_ids9 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 9;
            $attendance->answer = Answer::CONDITIONALYES;
            $attendance->dh_flag = false;
            $attendance->save();
        };

        // 9/21
        $player_ids10 = Player::query()
            ->whereIn('nickname', ['舩越', '山岸謙'])
            ->pluck('id');

        foreach ($player_ids10 as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 10;
            $attendance->answer = Answer::CONDITIONALYES;
            $attendance->dh_flag = false;
            $attendance->save();
        };
    }
}
