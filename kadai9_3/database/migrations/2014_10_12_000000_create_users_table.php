<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('ID');
            $table->string('access_token')->nullable()->comment('アクセストークン(英数字8文字)');
            $table->string('nickname')->comment('ニックネーム');
            $table->integer('level')->nullable()->default(1)->comment('レベル');
            $table->integer('exp')->nullable()->default(0)->comment('経験値');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
