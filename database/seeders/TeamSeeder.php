<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::query()->delete();

        $team = new Team();
        $team->team_name = 'Navies';
        $team->team_kana = 'ネイビーズ';
        $team->save();
    }
}
