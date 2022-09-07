<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishersidColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biblios', function(Blueprint $table){
            $table->unsignedBigInteger('publishers_id');
            $table->foreign('publishers_id')->references('id')->on('publishers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biblios', function(Blueprint $table){
            $table->dropForeign(['publishers_id']);
            $table->dropColumn('publishers_id');
        });
    }
}
