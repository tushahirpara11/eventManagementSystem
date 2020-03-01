<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_masters', function (Blueprint $table) {
            $table->increments('u_id',7);
            $table->string('f_name',50);
            $table->string('l_name',50);
            $table->string('email',60)->unique();                                                
            $table->string('phone',13)->unique();            
            $table->date('dob');
            $table->integer('b_id')->unsigned();
            $table->integer('s_id')->unsigned();
            $table->integer('d_id')->unsigned();            
            $table->string('gender',1);
            $table->integer('u_type')->unsigned();
            $table->string('password',500);
            $table->string('enrollmentno',12)->nullable();
            $table->foreign('b_id')->references('b_id')->on('branch_masters')->onUpdade('cascade')->onDelete('cascade');            
            $table->foreign('s_id')->references('s_id')->on('stream_masters')->onUpdade('cascade')->onDelete('cascade');            
            $table->foreign('d_id')->references('d_id')->on('division_masters')->onUpdade('cascade')->onDelete('cascade');            
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
        Schema::dropIfExists('user_masters');
    }
}
