<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Player;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::query()->delete();

        foreach (Player::pluck('id') as $index => $player_id) {
            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player_id;
            $attendance->activity_id = 1;
            // $attendance->answer = ($index <= 10) ? 1 : random_int(0, 1) * 2;
            $attendance->answer = 1;
            $attendance->dh_flag = false;
            $attendance->save();
        };
    }
}
