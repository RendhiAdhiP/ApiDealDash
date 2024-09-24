<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\LaporanPenjualan;
use App\Models\Produk;
use App\Models\StokProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index(){
        $produk = Produk::all();

        $data = $produk->map(function ($p) {
            return [
                'produk_id' => $p->produk_id,
                'nama' => $p->nama_produk,
                'stok' => $p->stok,
            ];
        });
        
        return ApiResponse::success('', $data, 200);
    }

    public function laporanPenjualan(){

        $data = LaporanPenjualan::latest('tanggal_penjualan')->get();

        $data = $data->map(function ($p) {
            return [
                'id' => $p->id,
                'produk' => $p->produk->nama_produk,
                'sales' => $p->sales->name,
                'jumlah_produk_terjual' => $p->jumlah_produk_terjual,
                'nominal_penjualan' => $p->nominal_penjualan,
                'tanggal_penjualan' => Carbon::parse($p->tanggal_penjualan)->format('d-m-Y'),
            ];
        });

        return ApiResponse::success('', $data, 200);
    }

    public function tambahPenjualan(Request $request){

        $request->validate([
            'produk_id' => 'required',
            'sales_id' => 'required',
            'jumlah_produk_terjual' => 'required'
        ]);

        try{

            $produk = Produk::where('produk_id', $request->produk_id)->first();
            $stokAwal = $produk->stok;
            if($produk && $produk->stok <= $request->jumlah_produk_terjual){
                return ApiResponse::error('Stok Tidak Cukup', 400);
            }

            $nominal_penjualan = $request->jumlah_produk_terjual * $produk->harga;

            $produk->stok -= $request->jumlah_produk_terjual;
            $produk->save();

            $stokProduk = StokProduk::create([
                'produk_id' => $request->produk_id,
                'update_stok'=> -$request->jumlah_produk_terjual,
                'stok' => $produk->stok,
                'stok_awal'=> $stokAwal
            ]);

            $data = LaporanPenjualan::create([
               'produk_id' => $request->produk_id,
               'sales_id' => $request->sales_id,
               'jumlah_produk_terjual' => $request->jumlah_produk_terjual,
               'nominal_penjualan' => $nominal_penjualan
            ]);

            return ApiResponse::success('Penjualan Berhasil Ditambahkan', $data, 200);

        }catch(\Exception $e){

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }

    }

}
