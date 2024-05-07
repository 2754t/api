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
        Schema::table('stadiums', function (Blueprint $table) {
            $table->integer('team_id')->comment('チームID')->after('id');
            $table->string('nearest_station', 100)->nullable()->comment('最寄駅')->after('parking_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stadiums', function (Blueprint $table) {
            $table->dropColumn('team_id');
            $table->dropColumn('nearest_station');
        });
    }
};
