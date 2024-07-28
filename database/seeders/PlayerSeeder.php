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

        $player1 = new Player();
        $player1->team_id = $team_id;
        $player1->email = 'navies@ymail.ne.jp';
        $player1->password = Hash::make('password');
        $player1->role = Role::ADMIN;
        $player1->last_name = '舩越';
        $player1->first_name = '貴矢';
        $player1->desired_position = Position::SHORT;
        $player1->position_joined = '2,3,4,5,6,7,8,9';
        $player1->pitcher_flag = false;
        // $player1->catcher_flag = true;
        $player1->catcher_flag = false;
        $player1->batting_order_bottom_flag = false;
        $player1->save();

        $player2 = new Player();
        $player2->team_id = $team_id;
        $player2->email = Str::random(10) . '@example.com';
        $player2->password = Hash::make('password');
        $player2->role = Role::MEMBER;
        $player2->last_name = '鴨頭';
        $player2->first_name = '慶樹';
        $player2->nickname = '鴨';
        $player2->desired_position = Position::SHORT;
        $player2->position_joined = '1,3,4,5,6,7,8,9';
        $player2->pitcher_flag = true;
        $player2->catcher_flag = false;
        $player2->batting_order_bottom_flag = false;
        $player2->save();

        $player3 = new Player();
        $player3->team_id = $team_id;
        $player3->email = Str::random(10) . '@example.com';
        $player3->password = Hash::make('password');
        $player3->role = Role::MEMBER;
        $player3->last_name = '西久保';
        $player3->first_name = Str::random(10);
        $player3->desired_position = null;
        $player3->position_joined = "2";
        $player3->pitcher_flag = false;
        $player3->catcher_flag = true;
        $player3->batting_order_bottom_flag = false;
        $player3->save();

        $player4 = new Player();
        $player4->team_id = $team_id;
        $player4->email = Str::random(10) . '@example.com';
        $player4->password = Hash::make('password');
        $player4->role = Role::MEMBER;
        $player4->last_name = '西本';
        $player4->first_name = Str::random(10);
        $player4->desired_position = Position::THIRD;
        $player4->position_joined = "3,4,5,6,7,8,9";
        $player4->pitcher_flag = false;
        $player4->catcher_flag = false;
        $player4->batting_order_bottom_flag = false;
        $player4->save();

        $player5 = new Player();
        $player5->team_id = $team_id;
        $player5->email = Str::random(10) . '@example.com';
        $player5->password = Hash::make('password');
        $player5->role = Role::MEMBER;
        $player5->last_name = '上利';
        $player5->first_name = Str::random(10);
        $player5->desired_position = null;
        $player5->position_joined = '1,3,7,9';
        $player5->pitcher_flag = true;
        $player5->catcher_flag = false;
        $player5->batting_order_bottom_flag = false;
        $player5->save();

        $player6 = new Player();
        $player6->team_id = $team_id;
        $player6->email = Str::random(10) . '@example.com';
        $player6->password = Hash::make('password');
        $player6->role = Role::MEMBER;
        $player6->last_name = '雅';
        $player6->first_name = Str::random(10);
        $player6->desired_position = null;
        $player6->position_joined = '8,9';
        $player6->pitcher_flag = false;
        $player6->catcher_flag = false;
        $player6->batting_order_bottom_flag = false;
        $player6->save();

        $player7 = new Player();
        $player7->team_id = $team_id;
        $player7->email = Str::random(10) . '@example.com';
        $player7->password = Hash::make('password');
        $player7->role = Role::MEMBER;
        $player7->last_name = '山岸';
        $player7->first_name = Str::random(10);
        $player7->desired_position = null;
        $player7->position_joined = '3';
        $player7->pitcher_flag = false;
        $player7->catcher_flag = false;
        $player7->batting_order_bottom_flag = false;
        $player7->save();

        $player8 = new Player();
        $player8->team_id = $team_id;
        $player8->email = Str::random(10) . '@example.com';
        $player8->password = Hash::make('password');
        $player8->role = Role::MEMBER;
        $player8->last_name = '山岸謙介';
        $player8->first_name = '謙介';
        $player8->nickname = '山岸けん';
        $player8->desired_position = null;
        $player8->position_joined = '6,8';
        $player8->pitcher_flag = false;
        $player8->catcher_flag = false;
        $player8->batting_order_bottom_flag = false;
        $player8->save();

        $player9 = new Player();
        $player9->team_id = $team_id;
        $player9->email = Str::random(10) . '@example.com';
        $player9->password = Hash::make('password');
        $player9->role = Role::MEMBER;
        $player9->last_name = '柏原';
        $player9->first_name = Str::random(10);
        $player9->desired_position = Position::SHORT;
        $player9->position_joined = "1,3,5,6,7,8,9";
        $player9->pitcher_flag = true;
        $player9->catcher_flag = false;
        $player9->batting_order_bottom_flag = false;
        $player9->save();

        $player10 = new Player();
        $player10->team_id = $team_id;
        $player10->email = Str::random(10) . '@example.com';
        $player10->password = Hash::make('password');
        $player10->role = Role::MEMBER;
        $player10->last_name = '清水';
        $player10->first_name = Str::random(10);
        $player10->desired_position = null;
        $player10->position_joined = "2,3,4,5,6,7,8,9";
        $player10->pitcher_flag = true;
        $player10->catcher_flag = false;
        $player10->batting_order_bottom_flag = true;
        $player10->save();

        $player11 = new Player();
        $player11->team_id = $team_id;
        $player11->email = Str::random(10) . '@example.com';
        $player11->password = Hash::make('password');
        $player11->role = Role::MEMBER;
        $player11->last_name = '矢口';
        $player11->first_name = Str::random(10);
        $player11->desired_position = Position::SECOND;
        $player11->position_joined = "3,4,5,6,7,8,9";
        $player11->pitcher_flag = false;
        $player11->catcher_flag = false;
        $player11->batting_order_bottom_flag = false;
        $player11->save();

        $player12 = new Player();
        $player12->team_id = $team_id;
        $player12->email = Str::random(10) . '@example.com';
        $player12->password = Hash::make('password');
        $player12->role = Role::MEMBER;
        $player12->last_name = '井岡';
        $player12->first_name = Str::random(10);
        $player12->desired_position = Position::THIRD;
        $player12->position_joined = "5,6,7,8,9";
        $player12->pitcher_flag = false;
        $player12->catcher_flag = false;
        $player12->batting_order_bottom_flag = false;
        $player12->save();

        $player13 = new Player();
        $player13->team_id = $team_id;
        $player13->email = Str::random(10) . '@example.com';
        $player13->password = Hash::make('password');
        $player13->role = Role::MEMBER;
        $player13->last_name = '竹添';
        $player13->first_name = Str::random(10);
        $player13->desired_position = Position::SECOND;
        $player13->position_joined = "1,3,4,5,6,7,8,9";
        $player13->pitcher_flag = true;
        $player13->catcher_flag = false;
        $player13->batting_order_bottom_flag = false;
        $player13->save();

        $player14 = new Player();
        $player14->team_id = $team_id;
        $player14->email = Str::random(10) . '@example.com';
        $player14->password = Hash::make('password');
        $player14->role = Role::MEMBER;
        $player14->last_name = '村井';
        $player14->first_name = Str::random(10);
        $player14->desired_position = Position::CENTER;
        $player14->position_joined = "1,2,3,4,5,6,7,8,9";
        $player14->pitcher_flag = true;
        $player14->catcher_flag = false;
        $player14->batting_order_bottom_flag = false;
        $player14->save();

        $player15 = new Player();
        $player15->team_id = $team_id;
        $player15->email = Str::random(10) . '@example.com';
        $player15->password = Hash::make('password');
        $player15->role = Role::MEMBER;
        $player15->last_name = '岡本';
        $player15->first_name = Str::random(10);
        $player15->desired_position = Position::FIRST;
        $player15->position_joined = '2,3,4,5,6,7,8,9';
        $player15->pitcher_flag = false;
        $player15->catcher_flag = false;
        $player15->batting_order_bottom_flag = false;
        $player15->save();

        $player16 = new Player();
        $player16->team_id = $team_id;
        $player16->email = Str::random(10) . '@example.com';
        $player16->password = Hash::make('password');
        $player16->role = Role::HELPER;
        $player16->last_name = '大塚';
        $player16->first_name = Str::random(10);
        $player16->desired_position = Position::SHORT;
        $player16->position_joined = '1,3,4,5,6';
        $player16->pitcher_flag = true;
        $player16->catcher_flag = false;
        $player16->batting_order_bottom_flag = false;
        $player16->save();

        $player17 = new Player();
        $player17->team_id = $team_id;
        $player17->email = Str::random(10) . '@example.com';
        $player17->password = Hash::make('password');
        $player17->role = Role::HELPER;
        $player17->last_name = '池尾';
        $player17->first_name = Str::random(10);
        $player17->desired_position = null;
        $player17->position_joined = null;
        $player17->pitcher_flag = false;
        $player17->catcher_flag = false;
        $player17->batting_order_bottom_flag = false;
        $player17->save();

        $player18 = new Player();
        $player18->team_id = $team_id;
        $player18->email = Str::random(10) . '@example.com';
        $player18->password = Hash::make('password');
        $player18->role = Role::HELPER;
        $player18->last_name = '蓬莱';
        $player18->first_name = Str::random(10);
        $player18->desired_position = null;
        $player18->position_joined = null;
        $player18->pitcher_flag = false;
        $player18->catcher_flag = false;
        $player18->batting_order_bottom_flag = false;
        $player18->save();

        $player19 = new Player();
        $player19->team_id = $team_id;
        $player19->email = Str::random(10) . '@example.com';
        $player19->password = Hash::make('password');
        $player19->role = Role::HELPER;
        $player19->last_name = '藤野';
        $player19->first_name = Str::random(10);
        $player19->desired_position = Position::RIGHT;
        $player19->position_joined = null;
        $player19->pitcher_flag = false;
        $player19->catcher_flag = false;
        $player19->batting_order_bottom_flag = false;
        $player19->save();

        $player20 = new Player();
        $player20->team_id = $team_id;
        $player20->email = Str::random(10) . '@example.com';
        $player20->password = Hash::make('password');
        $player20->role = Role::HELPER;
        $player20->last_name = '坂本';
        $player20->first_name = Str::random(10);
        $player20->desired_position = null;
        $player20->position_joined = null;
        $player20->pitcher_flag = false;
        $player20->catcher_flag = false;
        $player20->batting_order_bottom_flag = false;
        $player20->save();

        $player21 = new Player();
        $player21->team_id = $team_id;
        $player21->email = Str::random(10) . '@example.com';
        $player21->password = Hash::make('password');
        $player21->role = Role::HELPER;
        $player21->last_name = '永井';
        $player21->first_name = '慎太郎';
        $player21->desired_position = null;
        $player21->position_joined = '1,3,4,5,6,7,8,9';
        $player21->pitcher_flag = true;
        $player21->catcher_flag = false;
        $player21->batting_order_bottom_flag = false;
        $player21->save();

        $player22 = new Player();
        $player22->team_id = $team_id;
        $player22->email = Str::random(10) . '@example.com';
        $player22->password = Hash::make('password');
        $player22->role = Role::HELPER;
        $player22->last_name = '永井未来';
        $player22->first_name = '未来';
        $player22->desired_position = null;
        $player22->position_joined = '9';
        $player22->pitcher_flag = false;
        $player22->catcher_flag = false;
        $player22->batting_order_bottom_flag = false;
        $player22->save();

        $player23 = new Player();
        $player23->team_id = $team_id;
        $player23->email = Str::random(10) . '@example.com';
        $player23->password = Hash::make('password');
        $player23->role = Role::HELPER;
        $player23->last_name = '尾上';
        $player23->first_name = Str::random(10);
        $player23->desired_position = null;
        $player23->position_joined = null;
        $player23->pitcher_flag = false;
        $player23->catcher_flag = false;
        $player23->batting_order_bottom_flag = false;
        $player23->save();

        $player24 = new Player();
        $player24->team_id = $team_id;
        $player24->email = Str::random(10) . '@example.com';
        $player24->password = Hash::make('password');
        $player24->role = Role::HELPER;
        $player24->last_name = '青山';
        $player24->first_name = Str::random(10);
        $player24->desired_position = null;
        $player24->position_joined = null;
        $player24->pitcher_flag = false;
        $player24->catcher_flag = false;
        $player24->batting_order_bottom_flag = false;
        $player24->save();

        $player25 = new Player();
        $player25->team_id = $team_id;
        $player25->email = Str::random(10) . '@example.com';
        $player25->password = Hash::make('password');
        $player25->role = Role::EXPERIENCE;
        $player25->last_name = '塩谷';
        $player25->first_name = Str::random(10);
        $player25->desired_position = null;
        $player25->position_joined = null;
        $player25->pitcher_flag = false;
        $player25->catcher_flag = false;
        $player25->batting_order_bottom_flag = false;
        $player25->save();

        $player26 = new Player();
        $player26->team_id = $team_id;
        $player26->email = Str::random(10) . '@example.com';
        $player26->password = Hash::make('password');
        $player26->role = Role::EXPERIENCE;
        $player26->last_name = '田村';
        $player26->first_name = Str::random(10);
        $player26->desired_position = null;
        $player26->position_joined = null;
        $player26->pitcher_flag = false;
        $player26->catcher_flag = false;
        $player26->batting_order_bottom_flag = false;
        $player26->save();

        $player27 = new Player();
        $player27->team_id = $team_id;
        $player27->email = Str::random(10) . '@example.com';
        $player27->password = Hash::make('password');
        $player27->role = Role::EXPERIENCE;
        $player27->last_name = '横地';
        $player27->first_name = Str::random(10);
        $player27->desired_position = null;
        $player27->position_joined = null;
        $player27->pitcher_flag = false;
        $player27->catcher_flag = false;
        $player27->batting_order_bottom_flag = false;
        $player27->save();

        $player28 = new Player();
        $player28->team_id = $team_id;
        $player28->email = Str::random(10) . '@example.com';
        $player28->password = Hash::make('password');
        $player28->role = Role::EXPERIENCE;
        $player28->last_name = '緒方';
        $player28->first_name = Str::random(10);
        $player28->desired_position = null;
        $player28->position_joined = '4';
        $player28->pitcher_flag = true;
        $player28->catcher_flag = false;
        $player28->batting_order_bottom_flag = false;
        $player28->save();

        $player29 = new Player();
        $player29->team_id = $team_id;
        $player29->email = Str::random(10) . '@example.com';
        $player29->password = Hash::make('password');
        $player29->role = Role::EXPERIENCE;
        $player29->last_name = '八代谷';
        $player29->first_name = Str::random(10);
        $player29->desired_position = null;
        $player29->position_joined = '4,7,9';
        $player29->pitcher_flag = false;
        $player29->catcher_flag = false;
        $player29->batting_order_bottom_flag = false;
        $player29->save();

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
        //     $player->batting_order_bottom_flag = false;
        //     $player->save();
        // }
    }
}
