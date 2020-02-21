<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_masters', function (Blueprint $table) {
            $table->increments('e_id',7);
            $table->string('e_name',50);
            $table->string('e_discription',255);
            $table->integer('e_status')->unsigned();
            $table->date('e_start_date');
            $table->date('e_end_date');
            $table->integer('b_id')->unsigned();
            $table->integer('v_id')->unsigned();
            $table->foreign('b_id')->references('b_id')->on('branch_masters')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('v_id')->references('v_id')->on('venues')->onUpdade('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('event_masters');
    }
}
