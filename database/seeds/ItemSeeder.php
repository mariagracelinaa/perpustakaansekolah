<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'register_num' => '0001/per-C/Hd/2020/1',
            'biblios_id' => 1,
            'source' => 'pembelian',
            'price' => 89000,
            'status' => 'tersedia',
            'is_deleted' => 0,
        ]);

        DB::table('items')->insert([
            'register_num' => '0001/per-C/2022/1',
            'biblios_id' => 2,
            'source' => 'pembelian',
            'price' => 77000,
            'status' => 'tersedia',
            'is_deleted' => 0,
        ]);

        DB::table('items')->insert([
            'register_num' => '0001/per-C/Pb/2022/2',
            'biblios_id' => 1,
            'source' => 'hadiah',
            'price' => 0,
            'status' => 'tersedia',
            'is_deleted' => 0,
        ]);
    }
}
