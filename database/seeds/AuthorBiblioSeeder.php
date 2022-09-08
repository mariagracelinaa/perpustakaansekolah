<?php

use Illuminate\Database\Seeder;

class AuthorBiblioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors_biblios')->insert([
            'authors_id' => 1,
            'biblios_id' => 1,
            'primary_author' => 1,
        ]);

        DB::table('authors_biblios')->insert([
            'authors_id' => 2,
            'biblios_id' => 2,
            'primary_author' => 1,
        ]);
    }
}
