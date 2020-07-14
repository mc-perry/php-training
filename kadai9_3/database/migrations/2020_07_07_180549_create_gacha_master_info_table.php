<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGachaMasterInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gacha_master_info', function (Blueprint $table) {
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
        Schema::dropIfExists('gacha_master_info');
    }
}
