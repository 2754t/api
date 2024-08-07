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
            $table->string('password_token', 100)->nullable()->comment('パスワード再発行トークン');
            $table->dateTime('password_token_expired')->nullable()->comment('パスワード再発行トークン期限');
            $table->string('access_token', 100)->nullable()->comment('アクセストークン');
            $table->dateTime('access_token_expired')->nullable()->comment('アクセストークン有効期限');
            $table->string('last_name', 30)->comment('姓');
            $table->string('first_name', 30)->comment('名');
            $table->string('nickname', 30)->comment('ニックネーム');
            $table->tinyInteger('role')->default(30)->comment('権限 [1:管理者 10:メンバー 20:助っ人 30:体験者]');
            $table->tinyInteger('attendance_priority')->default(0)->comment('出席優先度');
            $table->integer('player_number')->nullable()->comment('背番号');
            $table->tinyInteger('desired_position')->nullable()->comment('希望ポジション');
            $table->string('position_joined', 20)->nullable()->comment('習得ポジション');
            $table->boolean('pitcher_flag')->default(false)->comment('投手フラグ');
            $table->boolean('catcher_flag')->default(false)->comment('捕手フラグ');
            $table->boolean('batting_order_bottom_flag')->default(false)->comment('先発時打順下位フラグ');
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
