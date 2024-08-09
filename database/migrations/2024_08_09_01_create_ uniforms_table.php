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
        Schema::create('uniforms', function (Blueprint $table) {
            $table->id()->comment('ユニフォーム注文ID');
            $table->foreignId('team_id')->comment('チームID');
            $table->foreignId('player_id')->comment('選手ID');
            $table->boolean('cap_flag')->default(false)->comment('帽子フラグ');
            $table->tinyInteger('cap_size')->nullable()->comment('帽子サイズ[54:S 56:M 58:L 60:O 62:XO 64:XXO]');
            $table->boolean('cap_adjuster_flag')->default(false)->comment('アジャスター(レール式)フラグ');
            $table->boolean('shirt_flag')->default(false)->comment('シャツフラグ');
            $table->string('back_name', 30)->nullable()->comment('背ネーム');
            $table->integer('player_number')->nullable()->comment('背番号');
            $table->tinyInteger('shirt_size')->nullable()->comment('シャツサイズ[88:S 92:M 96:L 100:O 104:XO 108:XA 112:XXA 116:XXB 122:B122 128:B128 134:B134 140:B140]');
            $table->tinyInteger('shirt_sleeve')->nullable()->comment('袖丈[1:短め 2:ノーマル 3:やや長め 4:長め]');
            $table->boolean('pants_flag')->default(false)->comment('パンツフラグ');
            $table->tinyInteger('pants_type')->nullable()->comment('パンツサイズ[1:ショート 2:レギュラー 3:ロング 4:ボンズ 5:スリムロング]');
            $table->tinyInteger('pants_hem')->nullable()->comment('すそ[1:ゴム入り 2:ゴムなし 3:ひっかけ]');
            $table->integer('pants_inseam')->nullable()->comment('股下');
            $table->integer('total_fee')->nullable()->comment('合計金額');
            $table->tinyText('note')->nullable()->comment('備考');
            $table->boolean('confirm_flag')->default(false)->comment('確定フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uniforms');
    }
};
