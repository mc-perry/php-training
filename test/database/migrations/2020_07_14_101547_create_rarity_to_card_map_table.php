<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRarityToCardMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rarity_to_card_map', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('ID');
            $table->integer('gacha_id')->comment('Gacha ID');
            $table->integer('rarity_level')->comment('Rarity Level');
            $table->integer('card_id')->comment('Card ID');
            $table->integer('card_weight')->comment('Card weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rarity_to_card_map');
    }
}
