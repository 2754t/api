<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Enums\Answer;
use App\Enums\Position;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Player;
use App\Services\Exceptions\NoCatcherException;
use App\Services\Exceptions\NoPitcherException;
use App\Services\Exceptions\NotEnoughMembersException;
use App\Services\StartingMemberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StartingMemberTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic test example.
     */
    public function test_generate_10(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 10; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = ($i === 1 || $i === 3);
            $player->catcher_flag = ($i === 2 || $i === 3);
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $starting_members = $service->generate($activity);

        $this->assertInstanceOf(Collection::class, $starting_members);
        $this->assertEquals(10, $starting_members->count());
        $batting_orders = $starting_members->pluck('batting_order');
        $this->assertEquals(10, $starting_members->unique()->count());
        $this->assertEquals(1, $starting_members->min('batting_order'));
        $this->assertEquals(10, $starting_members->max('batting_order'));

        $this->assertEquals(1, $starting_members->where('position', Position::PITCHER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::CATCHER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::FIRST)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::SECOND)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::THIRD)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::SHORT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::LEFT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::CENTER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::RIGHT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::DH)->count());
    }

    public function test_generate_9(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 9; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = ($i === 1 || $i === 3);
            $player->catcher_flag = ($i === 2 || $i === 3);
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $starting_members = $service->generate($activity);

        $this->assertInstanceOf(Collection::class, $starting_members);
        $this->assertEquals(9, $starting_members->count());
        $batting_orders = $starting_members->pluck('batting_order');
        $this->assertEquals(9, $starting_members->unique()->count());
        $this->assertEquals(1, $starting_members->min('batting_order'));
        $this->assertEquals(9, $starting_members->max('batting_order'));

        $this->assertEquals(1, $starting_members->where('position', Position::PITCHER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::CATCHER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::FIRST)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::SECOND)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::THIRD)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::SHORT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::LEFT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::CENTER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::RIGHT)->count());
        $this->assertEquals(0, $starting_members->where('position', Position::DH)->count());
    }

    public function test_generate_11(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 11; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = ($i === 1 || $i === 3);
            $player->catcher_flag = ($i === 2 || $i === 3);
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $starting_members = $service->generate($activity);

        $this->assertInstanceOf(Collection::class, $starting_members);
        $this->assertEquals(11, $starting_members->count());
        $batting_orders = $starting_members->pluck('batting_order');
        $this->assertEquals(11, $starting_members->unique()->count());
        $this->assertEquals(1, $starting_members->min('batting_order'));
        $this->assertEquals(11, $starting_members->max('batting_order'));

        $this->assertEquals(1, $starting_members->where('position', Position::PITCHER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::CATCHER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::FIRST)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::SECOND)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::THIRD)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::SHORT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::LEFT)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::CENTER)->count());
        $this->assertEquals(1, $starting_members->where('position', Position::RIGHT)->count());
        $this->assertEquals(2, $starting_members->where('position', Position::DH)->count());
    }

    public function test_generate_not_enough_members(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 8; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = ($i === 1 || $i === 3);
            $player->catcher_flag = ($i === 2 || $i === 3);
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $this->expectException(NotEnoughMembersException::class);
        $service->generate($activity);
    }

    public function test_generate_10_no_pitcher(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 10; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = false;
            $player->catcher_flag = ($i === 2 || $i === 3);
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $this->expectException(NoPitcherException::class);
        $service->generate($activity);
    }

    public function test_generate_10_no_catcher(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 10; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = ($i === 1 || $i === 3);
            $player->catcher_flag = false;
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $this->expectException(NoCatcherException::class);
        $service->generate($activity);
    }

    public function test_generate_10_only_one_pitcher_catcher(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->activity_date = today();
        $activity->activity_type = 1;
        $activity->save();

        for ($i = 1; $i <= 10; $i++) {
            $player = new Player();
            $player->team_id = 1;
            $player->email = sprintf("%s@example.com", $i);
            $player->password = 'password';
            $player->last_name = 'A';
            $player->first_name = 'A';
            $player->role = 1;
            $player->pitcher_flag = ($i === 1);
            $player->catcher_flag = ($i === 1);
            $player->save();

            $attendance = new Attendance();
            $attendance->team_id = 1;
            $attendance->player_id = $player->id;
            $attendance->activity_id = $activity->id;
            $attendance->answer = Answer::YES;
            $attendance->save();
        }

        $this->expectException(NoCatcherException::class);
        $service->generate($activity);
    }
}
