<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Produk;
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

    public function tambahPenjualan(Request $request){

        $request->validate([
            'produk_id' => 'required',
            'sales_id' => 'required',
            'jumlah_produk_terjual' => 'required',
            'nominal_penjualan' => 'required',
        ]);

        try{

        }catch(\Exception $e){

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }

    }

}
