<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_masters', function (Blueprint $table) {
            $table->increments('d_id',7);
            $table->integer('s_id')->unsigned();
            $table->string('d_name',20);
            $table->foreign('s_id')->references('s_id')->on('stream_masters')->onUpdade('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('division_masters');
    }
}
