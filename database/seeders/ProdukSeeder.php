<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'produk_id'=> 2523,
            'nama_produk' => 'Sunlite',
            'foto' => 'https://via.placeholder.com/150',
        ]);

        Produk::create([
            'produk_id'=> 2524,
            'nama_produk' => 'Ugreen',
            'foto' => 'https://via.placeholder.com/150' ,
        ]);
    }
}
