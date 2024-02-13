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
        Schema::table('players', function (Blueprint $table) {
            $table->integer('player_number')->nullable()->comment('背番号')->after('first_name');
            $table->integer('desired_position')->nullable()->comment('希望ポジション')->after('player_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('player_number');
            $table->dropColumn('desired_position');
        });
    }
};
