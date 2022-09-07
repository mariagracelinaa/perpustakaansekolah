<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsBibliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors_biblios', function (Blueprint $table) {
            $table->tinyInteger('primary_author')->length(1);
            $table->timestamps();
        });

        Schema::table('authors_biblios', function(Blueprint $table){
            $table->unsignedBigInteger('authors_id');
            $table->foreign('authors_id')->references('id')->on('authors');
        });
        
        Schema::table('authors_biblios', function(Blueprint $table){
            $table->unsignedBigInteger('biblios_id');
            $table->foreign('biblios_id')->references('id')->on('biblios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors_biblios', function(Blueprint $table){
            $table->dropForeign(['authors_id']);
            $table->dropColumn('authors_id');
        });

        Schema::table('authors_biblios', function(Blueprint $table){
            $table->dropForeign(['biblios_id']);
            $table->dropColumn('biblios_id');
        });

        Schema::dropIfExists('authors_biblios');
    }
}
