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
        Schema::table('attendances', function (Blueprint $table) {
            $table->boolean('dh_flag')->comment('DHフラグ')->after('answer');
            $table->tinyInteger('second_position')->nullable()->comment('第二ポジション')->after('dh_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('dh_flag');
            $table->dropColumn('second_position');
        });
    }
};
