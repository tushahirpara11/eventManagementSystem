<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costumes', function (Blueprint $table) {
            $table->increments('costume_id',7);            
            $table->integer('s_e_id')->unsigned();
            $table->integer('u_id')->unsigned();
            $table->integer('issuer')->unsigned();
            $table->integer('returner')->unsigned();
            $table->date('issue_date');
            $table->date('return_date')->nullable();            
            $table->integer('status')->unsigned();                    
            $table->foreign('s_e_id')->references('s_e_id')->on('sub_event_masters')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('u_id')->references('u_id')->on('user_masters')->onUpdade('cascade')->onDelete('cascade');                        
            $table->foreign('issuer')->references('u_id')->on('user_masters')->onUpdade('cascade')->onDelete('cascade');                        
            $table->foreign('returner')->references('u_id')->on('user_masters')->onUpdade('cascade')->onDelete('cascade');                        
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
        Schema::dropIfExists('costumes');
    }
}
