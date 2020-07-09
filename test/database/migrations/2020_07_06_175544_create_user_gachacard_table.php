<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGachaCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gacha_cards', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('ID');
            $table->integer('user_id')->comment('User ID');
            $table->integer('master_card_id')->comment('Master Card ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_gacha_cards');
    }
}
