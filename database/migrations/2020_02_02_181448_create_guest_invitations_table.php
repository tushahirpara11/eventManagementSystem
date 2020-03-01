<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_invitations', function (Blueprint $table) {
            $table->increments('i_id',7);            
            $table->integer('e_id')->unsigned();            
            $table->integer('guest_id')->unsigned();            
            $table->text('description');
            $table->date('date');
            $table->foreign('e_id')->references('e_id')->on('event_masters')->onUpdade('cascade')->onDelete('cascade');
            $table->foreign('guest_id')->references('guest_id')->on('guests')->onUpdade('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('guest_invitations');
    }
}
