<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNisnNiyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function(Blueprint $table){
            $table->string('nisn_niy');
            $table->foreign('nisn_niy')->references('nisn_niy')->on('users');
        });

        Schema::table('fines', function(Blueprint $table){
            $table->string('nisn_niy');
            $table->foreign('nisn_niy')->references('nisn_niy')->on('users');
        });

        Schema::table('suggestions', function(Blueprint $table){
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
        Schema::table('visits', function(Blueprint $table){
            $table->dropForeign(['nisn_niy']);
            $table->dropColumn('nisn_niy');
        });

        Schema::table('fines', function(Blueprint $table){
            $table->dropForeign(['nisn_niy']);
            $table->dropColumn('nisn_niy');
        });

        Schema::table('suggestions', function(Blueprint $table){
            $table->dropForeign(['nisn_niy']);
            $table->dropColumn('nisn_niy');
        });
    }
}
