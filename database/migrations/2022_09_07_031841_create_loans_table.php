<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->date('borrow_date');
            $table->date('due_date');
            $table->date('return_date');
            $table->enum('status',['belum kembali', 'sudah kembali'])->default('belum kembali');
            $table->timestamps();
        });

        Schema::table('loans', function(Blueprint $table){
            $table->string('register_num');
            $table->foreign('register_num')->references('register_num')->on('items');
        });
        
        Schema::table('loans', function(Blueprint $table){
            $table->unsignedBigInteger('biblios_id');
            $table->foreign('biblios_id')->references('id')->on('biblios');
        });

        Schema::table('loans', function(Blueprint $table){
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
        Schema::table('loans', function(Blueprint $table){
            $table->dropForeign(['biblios_id']);
            $table->dropColumn('biblios_id');
        });

        Schema::table('loans', function(Blueprint $table){
            $table->dropForeign(['nisn_niy']);
            $table->dropColumn('nisn_niy');
        });

        Schema::table('loans', function(Blueprint $table){
            $table->dropForeign(['register_num']);
            $table->dropColumn('register_num');
        });

        Schema::dropIfExists('loans');
    }
}
