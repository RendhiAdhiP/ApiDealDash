<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\LaporanPenjualan;
use App\Models\Produk;
use App\Models\StokProduk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jenisProduk = Produk::count();
        $stokbarang = Produk::sum('stok');
        $jumlaSales = User::where('role_id', 4)->count();
        $jumlahProdukTerjual = trim(StokProduk::where('update_stok', '<', 0)->sum('update_stok'),'-');
        $totalPendapatan = LaporanPenjualan::sum('nominal_penjualan');


        $data = [
            'JenisProduk' => $jenisProduk,
            'StokBarang' => (int) $stokbarang,
            'JumlahSales' => $jumlaSales,
            'JumlahProdukTerjual' => (int) $jumlahProdukTerjual,
            'TotalPendapatan' => (int) $totalPendapatan
        ];

        return ApiResponse::success('', $data, 200);
    }
}
