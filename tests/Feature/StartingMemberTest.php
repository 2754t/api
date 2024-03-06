<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Enums\ActivityType;
use App\Enums\Answer;
use App\Enums\DHType;
use App\Enums\Position;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Player;
use App\Services\Exceptions\NoCatcherException;
use App\Services\Exceptions\NoPitcherException;
use App\Services\Exceptions\NotEnoughMembersException;
use App\Services\StartingMemberService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StartingMemberTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function DH無制限9人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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

    /**
     * @test
     */
    public function DH1人設定で9人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::ONE;
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

    /**
     * @test
     */
    public function DHなし設定で9人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::ZERO;
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

    /**
     * @test
     */
    public function DH無制限10人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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

    /**
     * @test
     */
    public function DHひとり設定で10人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::ONE;
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

    /**
     * @test
     */
    public function DHなし設定で10人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::ZERO;
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
        $starting_lineup = $starting_members->where('starting_lineup', true);
        $this->assertEquals(9, $starting_lineup->count());

        $batting_orders = $starting_lineup->pluck('batting_order');
        $this->assertEquals(9, $batting_orders->unique()->count());
        $this->assertEquals(1, $batting_orders->min('batting_order'));
        $this->assertEquals(9, $batting_orders->max('batting_order'));

        $this->assertEquals(1, $starting_lineup->where('position', Position::PITCHER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::CATCHER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::FIRST)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::SECOND)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::THIRD)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::SHORT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::LEFT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::CENTER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::RIGHT)->count());
    }

    /**
     * @test
     */
    public function DH無制限11人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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

    /**
     * @test
     */
    public function DH1人設定で11人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::ONE;
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
        $starting_lineup = $starting_members->where('starting_lineup', true);
        $this->assertEquals(10, $starting_lineup->count());

        $batting_orders = $starting_lineup->pluck('batting_order');
        $this->assertEquals(10, $batting_orders->unique()->count());
        $this->assertEquals(1, $batting_orders->min('batting_order'));
        $this->assertEquals(10, $batting_orders->max('batting_order'));

        $this->assertEquals(1, $starting_lineup->where('position', Position::PITCHER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::CATCHER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::FIRST)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::SECOND)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::THIRD)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::SHORT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::LEFT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::CENTER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::RIGHT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::DH)->count());
    }

    /**
     * @test
     */
    public function DHなし設定で11人(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::ZERO;
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
        $starting_lineup = $starting_members->where('starting_lineup', true);
        $this->assertEquals(9, $starting_lineup->count());

        $batting_orders = $starting_lineup->pluck('batting_order');
        $this->assertEquals(9, $batting_orders->unique()->count());
        $this->assertEquals(1, $batting_orders->min('batting_order'));
        $this->assertEquals(9, $batting_orders->max('batting_order'));

        $this->assertEquals(1, $starting_lineup->where('position', Position::PITCHER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::CATCHER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::FIRST)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::SECOND)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::THIRD)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::SHORT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::LEFT)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::CENTER)->count());
        $this->assertEquals(1, $starting_lineup->where('position', Position::RIGHT)->count());
        $this->assertEquals(0, $starting_lineup->where('position', Position::DH)->count());
    }

    /**
     * @test
     */
    public function 試合ではない(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::PRACTICE;
        $activity->dh_type = DHType::UNLIMITED;
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

        $this->expectException(Exception::class);
        $starting_members = $service->generate($activity);
    }

    /**
     * @test
     */
    public function メンバー不足(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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

    /**
     * @test
     */
    public function ピッチャー不在(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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

    /**
     * @test
     */
    public function キャッチャー不在(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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

    /**
     * @test
     */
    public function ピッチャー兼キャッチャーが1人のみ(): void
    {
        $service = new StartingMemberService();

        $activity = new Activity();
        $activity->team_id = 1;
        $activity->stadium_id = 1;
        $activity->play_time = 2;
        $activity->confirmed_flag = true;
        $activity->activity_date = today();
        $activity->activity_type = ActivityType::GAME;
        $activity->dh_type = DHType::UNLIMITED;
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
