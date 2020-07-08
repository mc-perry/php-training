<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRarityWeightlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gacha_rarity_weightlist', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('Gacha ID');
            $table->integer('card_rarity')->comment('User ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gacha_rarity_weightlist');
    }
}
