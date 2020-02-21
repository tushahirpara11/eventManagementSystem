<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->increments('e_r_id',7);
            $table->integer('s_e_id')->unsigned();
            $table->integer('u_id')->unsigned();
            $table->integer('r_id')->unsigned();
            $table->integer('g_id')->unsigned();
            $table->integer('status')->unsigned();            
            $table->foreign('s_e_id')->references('s_e_id')->on('sub_event_masters')->onUpdade('cascade')->onDelete('cascade');            
            $table->foreign('u_id')->references('u_id')->on('user_masters')->onUpdade('cascade')->onDelete('cascade');  
            $table->foreign('r_id')->references('r_id')->on('roles')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('g_id')->references('g_id')->on('groups')->onUpdade('cascade')->onDelete('cascade');            
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
        Schema::dropIfExists('event_registrations');
    }
}
