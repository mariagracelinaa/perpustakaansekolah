<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->dateTime('reserve_date');
            $table->timestamps();
        });

        Schema::table('reservations', function(Blueprint $table){
            $table->unsignedBigInteger('biblios_id');
            $table->foreign('biblios_id')->references('id')->on('biblios');
        });
        
        Schema::table('reservations', function(Blueprint $table){
            $table->string('nisn_niy');
            $table->foreign('nisn_niy')->references('nisn_niy')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function(Blueprint $table){
            $table->dropForeign(['biblios_id']);
            $table->dropColumn('biblios_id');
        });

        Schema::table('reservations', function(Blueprint $table){
            $table->dropForeign(['nisn_niy']);
            $table->dropColumn('nisn_niy');
        });

        Schema::dropIfExists('reservations');
    }
}
