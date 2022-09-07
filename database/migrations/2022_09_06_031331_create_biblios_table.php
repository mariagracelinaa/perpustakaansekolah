<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBibliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biblios', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('isbn', 15);
            $table->integer('publish_year');
            $table->integer('purchase_year');
            $table->enum('ddc', ['000', '100','200','300','400','500','600','700','800','900']);
            $table->string('classification', 50);
            $table->string('image', 255);
            $table->integer('edition')->default(1);
            $table->integer('page');
            $table->integer('book_height');
            $table->enum('location', ['rak 000', 'rak 100','rak 200','rak 300','rak 400','rak 500','rak 600','rak 700','rak 800','rak 900']);
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
        Schema::dropIfExists('biblios');
    }
}
