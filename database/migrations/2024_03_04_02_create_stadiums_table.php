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
        Schema::create('stadiums', function (Blueprint $table) {
            $table->id()->comment('球場ID');
            $table->string('stadium_name', 50)->comment('球場名');
            $table->string('address', 100)->comment('住所');
            $table->integer('weekday_cost')->nullable()->comment('平日使用料金/h');
            $table->integer('saturday_cost')->nullable()->comment('土曜日使用料金/h');
            $table->integer('sunday_cost')->nullable()->comment('日曜日使用料金/h');
            $table->boolean('free_parking_flag')->nullable()->comment('無料駐車場フラグ');
            $table->integer('parking_cost')->nullable()->comment('近隣有料駐車場参考料金');
            $table->integer('from_station')->nullable()->comment('最寄駅からの徒歩時間(m)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stadiums');
    }
};
