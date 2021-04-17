<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('ユーザーID');
            $table->tinyInteger('type')->comment('作品タイプ(1: イラスト, 2: 小説)');
            $table->string('title')->comment('タイトル');
            $table->string('caption')->comment('キャプション');
            $table->tinyInteger('publish_status')->comment('公開状態(1: 全体, 2: 会員, 3: フォロワー, 4: 相互, 5: 非公開)');
            $table->tinyInteger('age_status')->comment('年齢制限(1: 全体, 2: 成人, 3: 成人+)');
            $table->string('password')->nullable()->comment('パスワード');
            $table->string('password_text')->nullable()->comment('パスワード説明');
            $table->string('thumbnail')->nullable()->comment('サムネイル画像');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
}
