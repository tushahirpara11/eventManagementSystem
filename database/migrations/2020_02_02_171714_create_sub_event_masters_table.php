<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubEventMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_event_masters', function (Blueprint $table) {
            $table->increments('s_e_id',7);
            $table->string('s_e_name',50);
            $table->string('s_e_discription',255);
            $table->integer('status')->unsigned();            
            $table->time('s_e_duration');
            $table->integer('e_id')->unsigned();
            $table->foreign('e_id')->references('e_id')->on('event_masters')->onUpdade('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sub_event_masters');
    }
}
