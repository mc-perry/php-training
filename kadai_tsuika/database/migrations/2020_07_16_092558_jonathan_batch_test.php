<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JonathanBatchTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jonathan_batch_test', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('ID');
            $table->timestamp('created_at')->comment('Created At');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
