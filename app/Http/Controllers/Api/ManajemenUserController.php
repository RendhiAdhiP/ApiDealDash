<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManajemenUserController extends Controller
{
    public function index(){

        $Alluser = User::with('kota')->get();

        $user = $Alluser->map(function ($u) {
            return [
                'id'=>$u->id,
                'nama' => $u->name,
                'email' => $u->email,
                'asal_kota' => $u->kota->kota,
            ];
        });

        return response()->json(['user'=>$user], 200);
    }

    public function tambahUser(Request $request){

        $request->validate([
            'name' => 'required',
            'foto' => 'file|image|mimes:jpeg,png,jpg',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $image_name = $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $image_name);
        }

        $user = User::create([
            'name' => $request->name,
            'foto' => $image_name ?? 'https://via.placeholder.com/640x480.png/0066aa?text=people+Faker+rem',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'kota_asal' => $request->kota_asal,

        ]);

        $data = [
            'id'=>$user->id,
            'nama'=>$user->name,
            'foto'=>$user->foto,
            'email'=>$user->email,
            'tanggal_lahir'=>$user->tanggal_lahir,
            'kota_asal'=>$user->kota->kota,
        ];

        return response()->json(['message'=>'succes created new user','user'=>$data], 201);
    }


    public function detailUser($id,Request $request ){

        $user = User::find($id);

        if(!$user){
            return response()->json(['message'=>'user not found'], 404);
        }

        $data = [
            'id'=>$user->id,
            'nama'=>$user->name,
            'foto'=>$user->foto,
            'email'=>$user->email,
            'tanggal_lahir'=>$user->tanggal_lahir,
            'kota_asal'=>$user->kota->kota,
        ];

        return response()->json(['user'=>$data], 200);
    } 

    public function editUser($id, Request $request){

        $user = User::find($id);

        if(!$user){
            return response()->json(['message'=>'user not found'], 404);
        }

        $data = [
            'id'=>$user->id,
            'nama'=>$user->name,
            'foto'=>$user->foto,
            'email'=>$user->email,
            'password'=>$user->password,
            'tanggal_lahir'=>$user->tanggal_lahir,
            'kota_asal'=>$user->kota->kota,
        ];

        return response()->json(['user'=>$data], 200);
    }

    public function updateUser($id,Request $request){

        $user = User::find($id);
        
        $request->validate([
            'name' => 'required',
            'foto' => 'file|image|mimes:jpeg,png,jpg',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $image_name = $request->name . '.' . $image->getClientOriginalExtension();

            Storage::delete('images/users/'.basename($user->foto));

            $image->move(public_path('images/users'), $image_name);
        }


        $user->update([
            'name' => $request->name,
            'foto' => $image_name ?? 'https://via.placeholder.com/640x480.png/0066aa?text=people+Faker+rem',
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'kota_asal' => $request->kota_asal,
        ]);

        $data = [
            'id'=>$user->id,
            'name'=>$user->name,
            'foto'=>$user->foto,
            'email'=>$user->email,
            'tanggal_lahir'=>$user->tanggal_lahir,
            'kota_asal'=>$user->kota->kota,
        ];


        return response()->json(['message'=>'succes update data user','user'=>$data], 201);

    }

    public function hapusUser($id){
        User::find($id)->delete();
        return response()->json(['message'=>'user deleted'], 200);
    }
}
