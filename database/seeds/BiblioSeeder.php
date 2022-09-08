<?php

use Illuminate\Database\Seeder;

class BiblioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('biblios')->insert([
            'id' => 1,
            'publishers_id' => 2,
            'title' => 'Habis gelap terbitlah terang',
            'isbn' => '9073990211189',
            'publish_year' => 2018,
            'purchase_year' => 2020,
            'ddc' => '300',
            'classification' => 'Sit h 300',
            'image' => 'hgtt.jpg',
            'edition' => 1,
            'page' => 164,
            'book_height' => 20,
            'location' => 'rak 300',
        ]);

        DB::table('biblios')->insert([
            'id' => 2,
            'publishers_id' => 1,
            'title' => 'Hujan dilangit senja',
            'isbn' => '9073990674440',
            'publish_year' => 2019,
            'purchase_year' => 2022,
            'ddc' => '300',
            'classification' => 'Ang h 300',
            'image' => 'hds.jpg',
            'edition' => 1,
            'page' => 164,
            'book_height' => 20,
            'location' => 'rak 300',
        ]);
    }
}
