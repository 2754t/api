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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id()->comment('出欠ID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('activity_id')->comment('活動ID');
            $table->foreignId('player_id')->comment('選手ID');
            $table->tinyInteger('answer')->default(0)->comment('出欠回答 [0:無回答 1:出席 2:欠席]');
            $table->boolean('dh_flag')->default(false)->comment('DHフラグ');
            $table->tinyText('note')->nullable()->comment('備考');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
