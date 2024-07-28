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

        $link3 = new Link();
        $link3->team_id = $team_id;
        $link3->player_id = null;
        $link3->activity_id = 2;
        $link3->url = 'https://youtu.be/JEF9Ut_UG7E?si=ttsKdtStZnBsmAoB';
        $link3->save();

        $link4 = new Link();
        $link4->team_id = $team_id;
        $link4->player_id = null;
        $link4->activity_id = 3;
        $link4->url = 'https://youtu.be/4C2GCSzz4iE?si=0T5NyFpEqRKdUL_I';
        $link4->save();

        $link5 = new Link();
        $link5->team_id = $team_id;
        $link5->player_id = null;
        $link5->activity_id = 4;
        $link5->url = 'https://youtu.be/n1e-M38lLxw?si=31x_gj0ZySWlKAwO';
        $link5->save();
    }
}
