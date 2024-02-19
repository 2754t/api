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
            $table->id()->comment('オーダーID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('player_id')->comment('選手ID');
            $table->foreignId('activity_id')->comment('活動ID');
            $table->boolean('starting_lineup')->default(false)->comment('スタメン');
            $table->tinyInteger('position')->nullable()->comment('守備位置');
            $table->tinyInteger('batting_order')->nullable()->comment('打順');
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
