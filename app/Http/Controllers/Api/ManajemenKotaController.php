<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;

class ManajemenKotaController extends Controller
{

    public function index(){
        $kota = Kota::all();
        return response()->json(['kota'=>$kota], 200);
    }

    public function tambahKota(Request $request){

        $request->validate([
            'kota' => 'required',
        ]);

        $kota = Kota::create([
            'kota' => $request->kota,
        ]); 

        return response()->json(['kota'=>$kota], 200);
    }

    public function editKota($id){

        $kota = Kota::find($id);

        return response()->json(['kota'=>$kota], 200);
    }


    public function updateKota(Request $request, $id){
        $request->validate([
            'kota' => 'required',
        ]);

        $kota = Kota::find($id);
        $kota->kota = $request->kota;
        $kota->save();

        return response()->json(['message'=>'succes update'], 200);
    }


    public function hapusKota($id){
        $kota = Kota::find($id);
        $kota->delete();
        return response()->json(['message'=>'succes delete'], 200);
    }
}
