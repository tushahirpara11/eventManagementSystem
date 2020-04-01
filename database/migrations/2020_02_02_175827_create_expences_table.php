<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expences', function (Blueprint $table) {
            $table->increments('expence_id', 7);
            $table->integer('e_t_id')->unsigned();
            $table->integer('e_id')->unsigned();
            $table->integer('s_e_id')->unsigned();
            $table->integer('u_id')->unsigned();            
            $table->text('description');
            $table->mediumInteger('amount')->unsigned();
            $table->tinyInteger('status');
            $table->foreign('e_t_id')->references('e_t_id')->on('expence_types')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('e_id')->references('e_id')->on('event_masters')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('s_e_id')->references('s_e_id')->on('sub_event_masters')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('u_id')->references('u_id')->on('user_masters')->onUpdade('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('expences');
    }
}
