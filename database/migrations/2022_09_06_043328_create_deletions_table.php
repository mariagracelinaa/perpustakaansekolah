<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deletions', function (Blueprint $table) {
            $table->id();
            $table->date('deletion_date');
            $table->string('description', 100);
            $table->timestamps();
        });

        Schema::table('deletions', function(Blueprint $table){
            $table->unsignedBigInteger('biblios_id')->default(0);
            $table->foreign('biblios_id')->references('id')->on('biblios');
        });

        Schema::table('deletions', function(Blueprint $table){
            $table->string('register_num')->default(0);
            $table->foreign('register_num')->references('register_num')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deletions', function(Blueprint $table){
            $table->dropForeign(['biblios_id']);
            $table->dropColumn('biblios_id');
        });

        Schema::table('deletions', function(Blueprint $table){
            $table->dropForeign(['register_num']);
            $table->dropColumn('register_num');
        });

        Schema::dropIfExists('deletions');
    }
}
