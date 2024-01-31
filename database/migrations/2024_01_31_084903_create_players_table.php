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
        Schema::create('players', function (Blueprint $table) {
            $table->id()->comment('選手ID');
            $table->foreignId('team_id')->comment('チームID');
            $table->string('email', 100)->comment('メールアドレス');
            $table->string('password', 191)->comment('パスワード');
            $table->string('last_name', 30)->comment('姓');
            $table->string('first_name', 30)->comment('名');
            $table->string('positions', 20)->nullable()->comment('カンマ区切りの守備位置');
            $table->boolean('pitcher_flag')->default(false)->comment('投手フラグ');
            $table->boolean('catcher_flag')->default(false)->comment('捕手フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
