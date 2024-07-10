<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Team;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Link::query()->delete();

        $team_id = Team::where('team_name', 'Navies')->first()->id;

        $link1 = new Link();
        $link1->team_id = $team_id;
        $link1->player_id = null;
        $link1->activity_id = 1;
        $link1->url = 'https://youtu.be/roDK9af4xSY?si=iEzTZXm-qgLRD280';
        $link1->save();

        $link2 = new Link();
        $link2->team_id = $team_id;
        $link2->player_id = null;
        $link2->activity_id = 1;
        $link2->url = 'https://youtu.be/71CwWPKHVeU?si=aPe63P_A9OQzhb0V';
        $link2->save();
    }
}
