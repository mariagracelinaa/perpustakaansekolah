<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('register_num', 50)->primary();
            $table->enum('source',['pembelian','hadiah'])->default('pembelian');
            $table->integer('price')->default(0);
            $table->enum('status',['dipinjam', 'tersedia'])->default('tersedia');
            $table->tinyInteger('is_deleted')->length(1)->default(0);
            $table->timestamps();
        });

        Schema::table('items', function(Blueprint $table){
            $table->unsignedBigInteger('biblios_id')->default(0);
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
        Schema::table('items', function(Blueprint $table){
            $table->dropForeign(['biblios_id']);
            $table->dropColumn('biblios_id');
        });

        Schema::dropIfExists('items');
    }
}
