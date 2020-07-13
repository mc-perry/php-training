<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstCardRarityWeightlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gacha_to_card_weightlist', function (Blueprint $table) {
            $table->integer('card_id')->comment('Card ID');
            $table->integer('gacha_id')->comment('Gacha ID');
            $table->integer('card_rarity')->comment('Card Rarity');
            $table->integer('card_weight')->comment('Gacha Card Single Weight Level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gacha_to_card_weightlist');
    }
}
