<?php

namespace Database\Seeders;

use App\Models\Kota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kota::insert([
            ['id' => 1, 'kota' => 'Jakarta'],
            ['id' => 2, 'kota' => 'Surabaya'],
            ['id' => 3, 'kota' => 'Bandung'],
            ['id' => 4, 'kota' => 'Medan'],
            ['id' => 5, 'kota' => 'Semarang'],
            ['id' => 6, 'kota' => 'Makassar'],
            ['id' => 7, 'kota' => 'Palembang'],
            ['id' => 8, 'kota' => 'Yogyakarta'],
            ['id' => 9, 'kota' => 'Denpasar'],
            ['id' => 10, 'kota' => 'Balikpapan'],
        ]);
    }
}
