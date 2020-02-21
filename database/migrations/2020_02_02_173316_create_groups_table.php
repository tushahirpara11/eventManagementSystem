<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('g_id',7);
            $table->integer('e_id')->unsigned();
            $table->integer('s_e_id')->unsigned();            
            $table->integer('u_id')->unsigned();
            $table->integer('r_id')->unsigned();
            $table->foreign('e_id')->references('e_id')->on('event_masters')->onUpdade('cascade')->onDelete('cascade');            
            $table->foreign('s_e_id')->references('s_e_id')->on('sub_event_masters')->onUpdade('cascade')->onDelete('cascade');            
            $table->foreign('u_id')->references('u_id')->on('user_masters')->onUpdade('cascade')->onDelete('cascade');  
            $table->foreign('r_id')->references('r_id')->on('roles')->onUpdade('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('groups');
    }
}
