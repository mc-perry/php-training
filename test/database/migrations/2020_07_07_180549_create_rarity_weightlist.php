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
        Schema::create('mst_rarity_weightlist', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('Gacha ID');
            $table->integer('card_rarity')->comment('User ID');
            $table->integer('user_id')->comment('User ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rarity_weightlist');
    }
}
