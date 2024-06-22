<?php

namespace Database\Seeders;

use App\Enums\ActivityType;
use App\Enums\DHType;
use App\Enums\RefereeType;
use App\Models\Activity;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::query()->delete();

        $team_id = Team::where('team_name', 'Navies')->first()->id;

        $activity1 = new Activity();
        $activity1->team_id = $team_id;
        $activity1->stadium_id = 3;
        $activity1->activity_datetime = '2024-07-13 15:00:00';
        $activity1->play_time = 2;
        $activity1->meeting_time = '開始15分前まで';
        $activity1->meeting_place = '一塁側';
        $activity1->activity_type = ActivityType::GAME;
        $activity1->confirmed_flag = false;
        $activity1->opposing_team = null;
        $activity1->referee_type = RefereeType::DISPATCH;
        $activity1->dh_type = DHType::ONE;
        $activity1->recruitment = 10;
        $activity1->entry_cost = 600;
        $activity1->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity1->decide_order_flag = false;
        $activity1->next_send_datetime = null;
        $activity1->save();

        $activity2 = new Activity();
        $activity2->team_id = $team_id;
        $activity2->stadium_id = 2;
        $activity2->activity_datetime = '2024-07-20 15:00:00';
        $activity2->play_time = 2;
        $activity2->meeting_time = '開始15分前まで';
        $activity2->meeting_place = '一塁側スタンド';
        $activity2->activity_type = ActivityType::GAME;
        $activity2->confirmed_flag = true;
        $activity2->opposing_team = 'ファイザーズ';
        $activity2->referee_type = RefereeType::DISPATCH;
        $activity2->dh_type = DHType::ONE;
        $activity2->recruitment = 10;
        $activity2->entry_cost = 700;
        $activity2->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity2->decide_order_flag = false;
        $activity2->next_send_datetime = null;
        $activity2->save();

        $activity3 = new Activity();
        $activity3->team_id = $team_id;
        $activity3->stadium_id = 1;
        $activity3->activity_datetime = '2024-07-27 11:00:00';
        $activity3->play_time = 2;
        $activity3->meeting_time = '開始15分前まで';
        $activity3->meeting_place = '一塁側入り口前';
        $activity3->activity_type = ActivityType::GAME;
        $activity3->confirmed_flag = true;
        $activity3->opposing_team = 'ロイヤルハニーズ';
        $activity3->referee_type = RefereeType::DISPATCH;
        $activity3->dh_type = DHType::ONE;
        $activity3->recruitment = 10;
        $activity3->entry_cost = 600;
        $activity3->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity3->decide_order_flag = false;
        $activity3->next_send_datetime = null;
        $activity3->save();

        $activity4 = new Activity();
        $activity4->team_id = $team_id;
        $activity4->stadium_id = 2;
        $activity4->activity_datetime = '2024-08-03 15:00:00';
        $activity4->play_time = 2;
        $activity4->meeting_time = '開始15分前まで';
        $activity4->meeting_place = '一塁側スタンド';
        $activity4->activity_type = ActivityType::GAME;
        $activity4->confirmed_flag = false;
        $activity4->opposing_team = null;
        $activity4->referee_type = RefereeType::DISPATCH;
        $activity4->dh_type = DHType::ONE;
        $activity4->recruitment = 10;
        $activity4->entry_cost = 700;
        $activity4->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity4->decide_order_flag = false;
        $activity4->next_send_datetime = null;
        $activity4->save();

        $activity5 = new Activity();
        $activity5->team_id = $team_id;
        $activity5->stadium_id = 3;
        $activity5->activity_datetime = '2024-08-10 15:00:00';
        $activity5->play_time = 2;
        $activity5->meeting_time = '開始15分前まで';
        $activity5->meeting_place = '一塁側';
        $activity5->activity_type = ActivityType::GAME;
        $activity5->confirmed_flag = false;
        $activity5->opposing_team = null;
        $activity5->referee_type = RefereeType::DISPATCH;
        $activity5->dh_type = DHType::ONE;
        $activity5->recruitment = 10;
        $activity5->entry_cost = 600;
        $activity5->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity5->decide_order_flag = false;
        $activity5->next_send_datetime = null;
        $activity5->save();

        $activity6 = new Activity();
        $activity6->team_id = $team_id;
        $activity6->stadium_id = 3;
        $activity6->activity_datetime = '2024-08-18 15:00:00';
        $activity6->play_time = 2;
        $activity6->meeting_time = '開始15分前まで';
        $activity6->meeting_place = '一塁側';
        $activity6->activity_type = ActivityType::GAME;
        $activity6->confirmed_flag = false;
        $activity6->opposing_team = null;
        $activity6->referee_type = RefereeType::DISPATCH;
        $activity6->dh_type = DHType::ONE;
        $activity6->recruitment = 10;
        $activity6->entry_cost = 600;
        $activity6->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity6->decide_order_flag = false;
        $activity6->next_send_datetime = null;
        $activity6->save();

        $activity7 = new Activity();
        $activity7->team_id = $team_id;
        $activity7->stadium_id = 3;
        $activity7->activity_datetime = '2024-08-24 15:00:00';
        $activity7->play_time = 2;
        $activity7->meeting_time = '開始15分前まで';
        $activity7->meeting_place = '一塁側';
        $activity7->activity_type = ActivityType::GAME;
        $activity7->confirmed_flag = false;
        $activity7->opposing_team = null;
        $activity7->referee_type = RefereeType::DISPATCH;
        $activity7->dh_type = DHType::ONE;
        $activity7->recruitment = 10;
        $activity7->entry_cost = 600;
        $activity7->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity7->decide_order_flag = false;
        $activity7->next_send_datetime = null;
        $activity7->save();

        $activity8 = new Activity();
        $activity8->team_id = $team_id;
        $activity8->stadium_id = 3;
        $activity8->activity_datetime = '2024-08-31 15:00:00';
        $activity8->play_time = 2;
        $activity8->meeting_time = '開始15分前まで';
        $activity8->meeting_place = '一塁側';
        $activity8->activity_type = ActivityType::GAME;
        $activity8->confirmed_flag = false;
        $activity8->opposing_team = null;
        $activity8->referee_type = RefereeType::DISPATCH;
        $activity8->dh_type = DHType::ONE;
        $activity8->recruitment = 10;
        $activity8->entry_cost = 600;
        $activity8->belongings = 'ユニフォーム（ジャージ可）、グローブ、スパイク（金具可）、参加費';
        $activity8->decide_order_flag = false;
        $activity8->next_send_datetime = null;
        $activity8->save();
    }
}
