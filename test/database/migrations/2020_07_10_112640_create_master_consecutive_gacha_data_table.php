<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterConsecutiveGachaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_consecutive_gacha', function (Blueprint $table) {
            $table->id();
            $table->integer('gacha_card_count')->comment('Consecutive Issue Count');
            $table->integer('maximum_rarity')->comment('Maximum Consecutive Gacha Rarity Level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_consecutive_gacha');
    }
}
