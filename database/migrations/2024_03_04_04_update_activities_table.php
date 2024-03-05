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
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('stadium_id')->comment('球場ID')->after('team_id');
            $table->boolean('confirmed_flag')->comment('活動確定フラグ')->after('activity_type');
            $table->tinyInteger('dh_type')->nullable()->comment('DHタイプ')->after('confirmed_flag');
            $table->integer('entry_cost')->nullable()->comment('参加費')->after('dh_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('stadium_id');
            $table->dropColumn('confirmed_flag');
            $table->dropColumn('dh_type');
            $table->dropColumn('entry_cost');
        });
    }
};
