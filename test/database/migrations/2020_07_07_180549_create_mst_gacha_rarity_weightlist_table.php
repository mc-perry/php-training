<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstGachaRarityWeightlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_gacha_rarity_weightlist', function (Blueprint $table) {
            $table->integer('gacha_id')->comment('Card ID');
            $table->integer('gacha_weight')->comment('Gacha Weight');
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
