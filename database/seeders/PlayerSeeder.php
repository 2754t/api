<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::query()->delete();

        for ($i = 1; $i <= 20; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = Str::random(10).'@example.com';
            $player->password = Hash::make('password');
            $player->last_name = Str::random(10);
            $player->first_name = Str::random(10);
            $player->positions = null;
            $player->pitcher_flag = random_int(0, 1);
            $player->catcher_flag = random_int(0, 1);
            $player->save();
        }
    }
}
