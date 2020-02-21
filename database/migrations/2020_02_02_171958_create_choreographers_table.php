<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChoreographersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choreographers', function (Blueprint $table) {
            $table->bigIncrements('c_id',7);
            $table->integer('s_e_id')->unsigned();
            $table->string('c_name',50);
            $table->string('c_phone',13)->unique();            
            $table->string('c_email',60)->unique();                                                
            $table->foreign('s_e_id')->references('s_e_id')->on('sub_event_masters')->onUpdade('cascade')->onDelete('cascade');            
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
        Schema::dropIfExists('choreographers');
    }
}
