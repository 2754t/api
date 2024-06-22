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
        Schema::create('starting_members', function (Blueprint $table) {
            $table->id()->comment('スタメンID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('attendance_id')->comment('出欠ID');
            $table->boolean('starting_flag')->default(false)->comment('スタメンフラグ');
            $table->tinyInteger('batting_order')->nullable()->comment('打順');
            $table->tinyInteger('position')->nullable()->comment('スタートポジション');
            $table->tinyInteger('second_position')->nullable()->comment('第二ポジション');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starting_members');
    }
};
