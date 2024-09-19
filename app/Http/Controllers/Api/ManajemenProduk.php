<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\HistoryProduk;
use App\Models\Produk;
use App\Models\StokProduk;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\map;

class ManajemenProduk extends Controller
{
    public function index()
    {

        try {

            $produk = Produk::all();
            // $produk = Produk::orderBy('created_at')->get();

            $data = $produk->map(function ($p) {
                return [
                    'produk_id' => $p->produk_id,
                    'nama' => $p->nama_produk,
                    'foto' => $p->foto,
                    // 'stok'=> $p->stok,
                    // 'tanggal' => Carbon::parse($p->created_at)->format('d-m-Y'),
                ];
            });

            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function tambahProduk(Request $request)
    {

        $request->validate([
            'produk_id' => 'required|unique:produks,produk_id',
            'nama_produk' => 'required',
        ]);

        if ($request->foto) {
            $request->validate([
                'foto' => 'file|image|mimes:jpeg,png,jpg'
            ]);
        }

        try {

            if ($request->hasFile('foto')) {

                $image = $request->file('foto');
                $image_name = str_replace(' ', '_', $request->nama_produk) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/produks'), $image_name);
            }

            $data = Produk::create([
                'produk_id' => $request->produk_id,
                'nama_produk' => $request->nama_produk,
                'foto' => $image_name ?? 'https://cdn-icons-png.flaticon.com/512/3081/3021994.png',
            ]);

            // HistoryProduk::create([
            //     'produk_id' => $data->id,
            //     'penambahan_stok' => $request->stok,
            //     'stok_awal' => 0, 
            //     'stok_akhir' => $request->stok,
            // ]);

            return ApiResponse::success('Berhasil Menambahkan Produk', $data, 201);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }


    public function editProduk($produkId)
    {
        try {

            $produk = Produk::where('produk_id', $produkId)->first();


            $data =  [
                'produk_id' => $produk->produk_id,
                'nama' => $produk->nama_produk,
                'foto' => $produk->foto,
            ];


            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }


    public function updateProduk(Request $request, $produkId)
    {

        $request->validate([
            'nama_produk' => 'required',
            'produk_id' => 'required',
        ]);


        if ($request->foto) {
            $request->validate([
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);
        }


        try {
            $data = [
                'nama_produk' => $request->nama_produk,
                'produk_id' => $request->produk_id,
            ];
            if ($request->hasFile('foto')) {

                $image = $request->file('foto');
                $image_name = str_replace(' ', '_', $request->nama_produk) . '.' . $image->getClientOriginalExtension();
                Storage::delete('images/produks/' . basename($request->foto));

                $image->move(public_path('images/produks'), $image_name);

                $data['foto'] = $image_name;
            }
            Produk::where('produk_id', $produkId)->update($data);

            return ApiResponse::success('Produk Berhasil Diupdate', $data, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function hapusProduk($produkId)
    {

        try {

            // $produk = Produk::();
            
            $produk = Produk::where('produk_id', $produkId)->first();

            if (!$produk) {
                return ApiResponse::error('Produk Tidak Ditemukan', 404);
            }

            $produk->delete();

            return ApiResponse::success('Produk Berhasil Dihapus', $produk, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function historyProduks()
    {
        try {

            $history = StokProduk::latest('update_stok_at')->with('produk')->get();


            $data = $history->map(function ($p) {
                return [
                    'id'=> $p->id,
                    'nama_produk'=> $p->produk->nama_produk,
                    'update_stok_at' => Carbon::parse($p->update_stok_at)->format('d-m-Y'),
                    'penambahan_stok' => $p->update_stok,
                    'stok_awal' => $p->stok_awal,
                    'stok_akhir' => $p->stok,
                ];
            });

            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }




    public function tambahStok(Request $request)
    {

        $request->validate([
            'produk_id' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        try {

            $produk = Produk::where('produk_id', $request->produk_id)->first();



            $stokProduk = StokProduk::where('produk_id', $request->produk_id)->with('produk')->first();

            if ($stokProduk) {

                
                $stokAwal = $stokProduk->stok;
                $stokAkhir = $stokAwal + $request->stok;

                $stokProduk->stok = $stokAkhir;
                $stokProduk->update_stok += $request->stok;
                $stokProduk->save();


                StokProduk::create([
                    'produk_id' => $produk->produk_id,
                    'stok' => (int) $stokAkhir,
                    'update_stok' => (int) $request->stok,
                    'stok_awal' => $stokAwal,
                ]);
            } else {
                
                $stokAwal = 0; 
                $stokAkhir = $request->stok; 

                $stokProduk = StokProduk::create([
                    'produk_id' => $produk->produk_id,
                    'stok' => $stokAkhir,
                    'update_stok' => $request->stok,
                    'stok_awal' => $stokAwal,
                ]);
            }



            return ApiResponse::success('Berhasil Menambahkan Stok', [], 201);
        } catch (\Exception $e) {

            Log::Error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }
}
