<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleshotGachaRarityWeightlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singleshot_gacha_rarity_weightlist', function (Blueprint $table) {
            $table->bigIncrements('rarity_level')->autoIncrement()->comment('Card Rarity Level');
            $table->integer('rarity_level_weight')->comment('Rarity Level Weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('singleshot_gacha_rarity_weightlist');
    }
}
