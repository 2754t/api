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
            ->whereIn('last_name', ['舩越', '西久保', '山岸', '山岸謙介', '竹添', '西本', '永井', '雅', '清水', 'タムタム'])
            ->pluck('id');

        foreach ($player_ids as $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = $team_id;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 2;
            $attendance->answer = Answer::YES;
            $attendance->dh_flag = false;
            $attendance->save();
        };
    }
}
