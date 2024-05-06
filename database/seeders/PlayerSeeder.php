<?php

namespace Database\Seeders;

use App\Enums\Position;
use App\Enums\Role;
use App\Models\Player;
use Illuminate\Database\Seeder;
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

        $player = new Player();
        $player->team_id = 1;
        $player->email = 'funakoshi@ad5.jp';
        $player->password = Hash::make('password');
        $player->role = Role::ADMIN;
        $player->last_name = '舩越';
        $player->first_name = '貴矢';
        $player->desired_position = Position::SHORT;
        $player->positions = '2,3,4,5,6,7,8,9';
        $player->pitcher_flag = false;
        $player->catcher_flag = true;
        $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '西久保';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->positions = "2";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '西本';
        $player->first_name = Str::random(10);
        $player->desired_position = 5;
        $player->positions = "3,4,5,6,7,8,9";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '岡本';
        $player->first_name = Str::random(10);
        $player->desired_position = 3;
        $player->positions = '2,3,4,5,6,7,8,9';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '竹添';
        $player->first_name = Str::random(10);
        $player->desired_position = 6;
        $player->positions = "1,3,4,5,6,7,8,9";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '谷口';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->positions = "3,4,5,6,7,8,9";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::HELPER;
        // $player->last_name = '柏原';
        // $player->first_name = Str::random(10);
        // $player->desired_position = 6;
        // $player->positions = "1,3,5,6,7,8,9";
        // $player->pitcher_flag = true;
        // $player->catcher_flag = false;
        // $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::HELPER;
        // $player->last_name = '清水';
        // $player->first_name = Str::random(10);
        // $player->desired_position = 5;
        // $player->positions = "2,3,4,5,6,7,8,9";
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::MEMBER;
        // $player->last_name = '鴨';
        // $player->first_name = Str::random(10);
        // $player->desired_position = 6;
        // $player->positions = '1,3,4,5,6,7,8,9';
        // $player->pitcher_flag = true;
        // $player->catcher_flag = false;
        // $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::EXPERIENCE;
        // $player->last_name = '雅';
        // $player->first_name = Str::random(10);
        // $player->desired_position = null;
        // $player->positions = null;
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::EXPERIENCE;
        // $player->last_name = 'かず';
        // $player->first_name = Str::random(10);
        // $player->desired_position = null;
        // $player->positions = null;
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::HELPER;
        // $player->last_name = 'しん';
        // $player->first_name = Str::random(10);
        // $player->desired_position = null;
        // $player->positions = null;
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '永井夫婦';
        $player->first_name = '慎&未';
        $player->desired_position = 4;
        $player->positions = '1,3,4,5,6,7,8,9';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::MEMBER;
        // $player->last_name = '永井';
        // $player->first_name = '慎太郎';
        // $player->desired_position = 5;
        // $player->positions = '1,3,4,5,6,7,8,9';
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::MEMBER;
        // $player->last_name = '永井';
        // $player->first_name = '未来';
        // $player->desired_position = null;
        // $player->positions = '9';
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '大塚';
        $player->first_name = Str::random(10);
        $player->desired_position = 6;
        $player->positions = '1,3,4,5,6';
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::HELPER;
        // $player->last_name = '藤野';
        // $player->first_name = Str::random(10);
        // $player->desired_position = 9;
        // $player->positions = null;
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '坂本';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->positions = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->save();


        $player = new Player();
        $player->team_id = 1;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '村井';
        $player->first_name = Str::random(10);
        $player->desired_position = 8;
        $player->positions = "1,2,3,4,5,6,7,8,9";
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->save();

        // $player = new Player();
        // $player->team_id = 1;
        // $player->email = Str::random(10) . '@example.com';
        // $player->password = Hash::make('password');
        // $player->role = Role::HELPER;
        // $player->last_name = '蓬莱';
        // $player->first_name = Str::random(10);
        // $player->desired_position = null;
        // $player->positions = null;
        // $player->pitcher_flag = false;
        // $player->catcher_flag = false;
        // $player->save();

        // for ($i = 1; $i <= 10; $i++) {
        //     $player = new Player();
        //     $player->team_id = 1;
        //     $player->email = Str::random(10) . '@example.com';
        //     $player->password = Hash::make('password');
        //     $player->last_name = Str::random(10);
        //     $player->first_name = Str::random(10);
        //     $player->positions = null;
        //     $player->pitcher_flag = random_int(0, 1);
        //     $player->catcher_flag = random_int(0, 1);
        //     $player->save();
        // }
    }
}
