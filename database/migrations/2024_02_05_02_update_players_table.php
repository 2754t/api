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
            $table->string('access_token', 100)->nullable()->comment('アクセストークン')->after('password');
            $table->dateTime('access_token_expired')->nullable()->comment('アクセストークン有効期限')->after('access_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('access_token');
            $table->dropColumn('access_token_expired');
        });
    }
};
