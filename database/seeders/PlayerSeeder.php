<?php

namespace Database\Seeders;

use App\Enums\Position;
use App\Enums\Role;
use App\Models\Player;
use App\Models\Team;
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

        $team_id = Team::where('team_name', 'Navies')->first()->id;

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = 'navies@ymail.ne.jp';
        $player->password = Hash::make('password');
        $player->role = Role::ADMIN;
        $player->last_name = '舩越';
        $player->first_name = '貴矢';
        $player->desired_position = Position::FIRST;
        $player->position_joined = '2,3,4,5,6,7,8,9';
        $player->pitcher_flag = false;
        $player->catcher_flag = true;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '鴨頭';
        $player->first_name = '慶樹';
        $player->nickname = '鴨';
        $player->desired_position = Position::SHORT;
        $player->position_joined = '1,3,4,5,6,7,8,9';
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '西久保';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = "2";
        $player->pitcher_flag = false;
        $player->catcher_flag = true;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '西本';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::THIRD;
        $player->position_joined = "3,4,5,6,7,8,9";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '上利';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = '1,3,7,9';
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '雅';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = '7,8,9';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '山岸';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = '3,4,6';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '山岸謙介';
        $player->first_name = '謙介';
        $player->nickname = '山岸けん';
        $player->desired_position = null;
        $player->position_joined = '6,8';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '柏原';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::SHORT;
        $player->position_joined = "1,3,5,6,7,8,9";
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '清水';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = "2,3,4,5,6,7,8,9";
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = true;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '矢口';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::SECOND;
        $player->position_joined = "3,4,5,6,7,8,9";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '井岡';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = "2,7,8,9";
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '竹添';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::SECOND;
        $player->position_joined = "1,3,4,5,6,7,8,9";
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '村井';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::CENTER;
        $player->position_joined = "1,2,3,4,5,6,7,8,9";
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::MEMBER;
        $player->last_name = '岡本';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::FIRST;
        $player->position_joined = '2,3,4,5,6,7,8,9';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '大塚';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::SHORT;
        $player->position_joined = '1,3,4,5,6';
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '池尾';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '蓬莱';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '藤野';
        $player->first_name = Str::random(10);
        $player->desired_position = Position::RIGHT;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '坂本';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '永井';
        $player->first_name = '慎太郎';
        $player->desired_position = null;
        $player->position_joined = '1,3,4,5,6,7,8,9';
        $player->pitcher_flag = true;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '永井未来';
        $player->first_name = '未来';
        $player->desired_position = null;
        $player->position_joined = '9';
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '尾上';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::HELPER;
        $player->last_name = '青山';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::EXPERIENCE;
        $player->last_name = '塩谷';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        $player = new Player();
        $player->team_id = $team_id;
        $player->email = Str::random(10) . '@example.com';
        $player->password = Hash::make('password');
        $player->role = Role::EXPERIENCE;
        $player->last_name = 'タムタム';
        $player->first_name = Str::random(10);
        $player->desired_position = null;
        $player->position_joined = null;
        $player->pitcher_flag = false;
        $player->catcher_flag = false;
        $player->batting_order_bottom_flag = false;
        $player->save();

        // for ($i = 1; $i <= 10; $i++) {
        //     $player = new Player();
        //     $player->team_id = $team_id;
        //     $player->email = Str::random(10) . '@example.com';
        //     $player->password = Hash::make('password');
        //     $player->last_name = Str::random(10);
        //     $player->first_name = Str::random(10);
        //     $player->position_joined = null;
        //     $player->pitcher_flag = random_int(0, 1);
        //     $player->catcher_flag = random_int(0, 1);
        $player->batting_order_bottom_flag = false;
        //     $player->save();
        // }
    }
}
