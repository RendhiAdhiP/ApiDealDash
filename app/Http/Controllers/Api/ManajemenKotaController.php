<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManajemenKotaController extends Controller
{

    public function index()
    {
        try {
            $data = Kota::all();

            return ApiResponse::success('', $data, 200);

        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function tambahKota(Request $request)
    {

        $request->validate([
            'kota' => 'required|unique:kotas,kota',
        ]);

        try {

            Kota::create([
                'kota' => $request->kota
            ]);

            return ApiResponse::success('Berhasil Menambahkan Kota', [], 201);

        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function editKota($id)
    {

        try {
            $data = Kota::find($id);

            if (!$data) {
                return ApiResponse::error('Kota Tidak Ditemukan', 404);
            }

            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }


    public function updateKota(Request $request, $id)
    {

        $request->validate([
           'kota' => 'required|unique:kotas,kota,' . $id,
        ]);

        try {

            $data = Kota::find($id);

            if (!$data) {
                return ApiResponse::error('Kota Tidak Ditemukan', 404);
            }

            $data->update([
                'kota' => $request->kota
            ]);

            return ApiResponse::success('Berhasil Mengedit Kota', [], 201);

        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }


    public function hapusKota($id)
    {

        try {
            $data = Kota::find($id);

            if (!$data) {
                return response()->json(['message' => 'data Tidak Ditemukan'], 404);
            }

            $data->delete();
            return ApiResponse::success('Berhasil Menghapus Kota', [], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }
}
