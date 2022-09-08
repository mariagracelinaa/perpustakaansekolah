<?php

use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publishers')->insert([
            'id' => 1,
            'name' => 'PT. Gramedia Pusta',
            'city' => 'Jakarta'
        ]);

        DB::table('publishers')->insert([
            'id' => 2,
            'name' => 'Ganesha',
            'city' => 'Jakarta'
        ]);

        DB::table('publishers')->insert([
            'id' => 3,
            'name' => 'Sumber Bahagia',
            'city' => 'Surabaya'
        ]);
    }
}
