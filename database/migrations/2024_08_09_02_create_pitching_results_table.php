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
        Schema::create('pitching_results', function (Blueprint $table) {
            $table->id()->comment('投手成績ID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('activity_id')->comment('活動ID');
            $table->foreignId('player_id')->comment('選手ID');
            $table->integer('outs')->default(0)->comment('奪アウト数(投球イニング×3)');
            $table->integer('hits')->default(0)->comment('被安打');
            $table->integer('walks')->default(0)->comment('与四死球');
            $table->integer('strikeouts')->default(0)->comment('奪三振');
            $table->integer('runs')->default(0)->comment('失点');
            $table->integer('earned_run')->default(0)->comment('自責点');
            $table->integer('pitching_evaluation')->nullable()->comment('登板評価[1:勝 2:負 3:ホールド 4:セーブ]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pitching_results');
    }
};
