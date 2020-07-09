<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCardDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_card_data', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('ID');
            $table->string('card_name')->comment('カード名');
            $table->integer('rarity')->comment('レア性');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_card_data');
    }
}
