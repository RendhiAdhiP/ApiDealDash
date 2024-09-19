<?php

namespace Database\Seeders;

use App\Models\HistoryProduk;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoryProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkA = Produk::where('nama_produk', 'Produk A')->first();
        $produkB = Produk::where('nama_produk', 'Produk B')->first();

        // History untuk Produk A
        HistoryProduk::create([
            'produk_id' => $produkA->id,
            'penambahan_stok' => 20,
            'stok_awal' => 100,
            'stok_akhir' => 120,
        ]);

        HistoryProduk::create([
            'produk_id' => $produkA->id,
            'penambahan_stok' => 30,
            'stok_awal' => 120,
            'stok_akhir' => 150,
        ]);

        // History untuk Produk B
        HistoryProduk::create([
            'produk_id' => $produkB->id,
            'penambahan_stok' => 10,
            'stok_awal' => 50,
            'stok_akhir' => 60,
        ]);
    }
}
