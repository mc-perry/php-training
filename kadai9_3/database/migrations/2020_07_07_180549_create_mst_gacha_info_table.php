<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstGachaInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_gacha_info', function (Blueprint $table) {
            $table->integer('gacha_id')->comment('Card ID');
            $table->integer('number_of_cards')->comment('Number of Cards');
            $table->integer('maximum_rarity')->comment('Maximum Rarity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_gacha_info');
    }
}
