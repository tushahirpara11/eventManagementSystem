<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_masters', function (Blueprint $table) {
            $table->increments('s_id',7);
            $table->integer('b_id')->unsigned();
            $table->string('s_name',50);
            $table->foreign('b_id')->references('b_id')->on('branch_masters')->onUpdade('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stream_masters');
    }
}
