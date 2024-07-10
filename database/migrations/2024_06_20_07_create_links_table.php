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
        Schema::create('links', function (Blueprint $table) {
            $table->id()->comment('リンクID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('player_id')->nullable()->comment('選手ID');
            $table->foreignId('activity_id')->nullable()->comment('活動ID');
            $table->text('url')->comment('URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
