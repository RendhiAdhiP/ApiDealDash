<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;

class ManajemenKotaController extends Controller
{

    public function index()
    {
        $kota = Kota::all();
        return response()->json(['kota' => $kota], 200);
    }

    public function tambahKota(Request $request)
    {

        $request->validate([
            'kota' => 'required|unique:kotas,kota',
        ]);

        $kota = Kota::create([
            'kota' => $request->kota
        ]);

        return response()->json(['message' => 'Berhasil Menambahkan Kota',], 201);
    }

    public function editKota($id)
    {

        $kota = Kota::find($id);

        return response()->json(['kota' => $kota], 200);
    }


    public function updateKota(Request $request, $id)
    {
        $request->validate([
            'kota' => 'required',
        ]);

        $kota = Kota::find($id);
        $kota->kota = $request->kota;
        $kota->save();

        return response()->json(['message' => 'Berhasil Menghapus Kota'], 201);
    }


    public function hapusKota($id)
    {

            $kota = Kota::find($id);

            if (!$kota) {
                return response()->json(['message' => 'Kota Tidak Ditemukan'], 404);
            }

            $kota->delete();
            return response()->json(['message' => 'Berhasil Menghapus Kota'], 200);
  
    }
}
