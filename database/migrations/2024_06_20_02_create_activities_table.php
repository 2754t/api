<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id()->comment('活動ID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('stadium_id')->comment('球場ID');
            $table->dateTime('activity_datetime')->comment('活動日時');
            $table->integer('play_time')->comment('活動の予定時間(h)');
            $table->string('meeting_time', 100)->comment('集合時間');
            $table->string('meeting_place', 100)->comment('集合場所');
            $table->tinyInteger('activity_type')->comment('活動内容 [0:練習 1:試合 2:紅白戦]');
            $table->boolean('confirmed_flag')->default(false)->comment('活動確定フラグ');
            $table->string('opposing_team', 100)->nullable()->comment('相手チーム');
            $table->tinyInteger('referee_type')->nullable()->comment('審判の種類');
            $table->tinyInteger('dh_type')->nullable()->comment('DHタイプ [0:0人 1:1人 2:2人以上]');
            $table->integer('recruitment')->nullable()->comment('募集人数');
            $table->integer('entry_cost')->nullable()->comment('参加費');
            $table->tinyText('belongings')->nullable()->comment('持ち物');
            $table->boolean('decide_order_flag')->default(false)->comment('オーダー決定フラグ');
            $table->dateTime('next_send_datetime')->nullable()->comment('次回送信日時');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
