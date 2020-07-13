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
        Schema::create('mst_card_rarity_weightlist', function (Blueprint $table) {
            $table->integer('card_id')->comment('Card ID');
            $table->integer('card_rarity')->comment('Card Rarity');
            $table->integer('card_single_weight')->comment('Gacha Card Single Weight Level');
            $table->integer('card_consecutive_weight')->comment('Gacha Card Tentimes Weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_card_rarity_weightlist');
    }
}
