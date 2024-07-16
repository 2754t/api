<?php

namespace Database\Seeders;

use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Database\Seeder;

class StadiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stadium::query()->delete();

        $team_id = Team::where('team_name', 'Navies')->first()->id;

        $stadium1 = new Stadium();
        $stadium1->team_id = $team_id;
        $stadium1->stadium_name = '猪名川公園野球場';
        $stadium1->address = '兵庫県尼崎市椎堂１丁目３５';
        $stadium1->weekday_cost = 1200;
        $stadium1->saturday_cost = 1200;
        $stadium1->sunday_cost = 1440;
        $stadium1->free_parking_flag = true;
        $stadium1->parking_cost = null;
        $stadium1->nearest_station = '阪急園田駅';
        $stadium1->from_station = 23;
        $stadium1->save();

        $stadium2 = new Stadium();
        $stadium2->team_id = $team_id;
        $stadium2->stadium_name = '宝塚市立スポーツセンター野球場';
        $stadium2->address = '兵庫県宝塚市小浜１丁目１−１１';
        $stadium2->weekday_cost = 1800;
        $stadium2->saturday_cost = 2160;
        $stadium2->sunday_cost = 2160;
        $stadium2->free_parking_flag = false;
        $stadium2->parking_cost = 200;
        $stadium2->nearest_station = '阪急逆瀬川駅';
        $stadium2->from_station = 22;
        $stadium2->save();

        $stadium3 = new Stadium();
        $stadium3->team_id = $team_id;
        $stadium3->stadium_name = '宝塚市立売布北グラウンド';
        $stadium3->address = '兵庫県宝塚市売布自由ガ丘８−１';
        $stadium3->weekday_cost = 1200;
        $stadium3->saturday_cost = 1440;
        $stadium3->sunday_cost = 1440;
        $stadium3->free_parking_flag = true;
        $stadium3->parking_cost = null;
        $stadium3->nearest_station = '阪急売布神社駅';
        $stadium3->from_station = 15;
        $stadium3->save();
    }
}
