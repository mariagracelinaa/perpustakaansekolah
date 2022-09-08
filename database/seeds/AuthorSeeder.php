<?php

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->insert([
            'id' => 1,
            'name' => 'Siti Mariam',
        ]);

        DB::table('authors')->insert([
            'id' => 2,
            'name' => 'Angeline Amelia',
        ]);
    }
}
