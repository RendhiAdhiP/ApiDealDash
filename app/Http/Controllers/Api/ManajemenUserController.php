<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManajemenUserController extends Controller
{
    public function index()
    {

        $Alluser = User::with('kota')->get();

        $user = $Alluser->map(function ($u) {
            return [
                'id' => $u->id,
                'nama' => $u->name,
                'email' => $u->email,
                'asal_kota' => $u->kota->kota,
            ];
        });

        return response()->json(['user' => $user], 200);
    }

    public function tambahUser(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $image_name = str_replace(' ', '_', $request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $image_name);
        }

        $user = User::create([
            'name' => $request->name,
            'foto' => $image_name ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'kota_asal' => $request->kota_asal,

        ]);

        $data = [
            'id' => $user->id,
            'nama' => $user->name,
            'foto' => $user->foto,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'kota_asal' => $user->kota->kota,
        ];

        return response()->json(['message' => 'Berhasil Menambahkan User', 'user' => $data], 201);
    }


    public function detailUser($id, Request $request)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User Tidak Ditemukan'], 404);
        }

        $data = [
            'id' => $user->id,
            'nama' => $user->name,
            'foto' => $user->foto,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'kota_asal' => $user->kota->kota,
        ];

        return response()->json(['user' => $data], 200);
    }

    public function editUser($id, Request $request)
    {

        $user = User::with('kota')->find($id);

        if (!$user) {
            return response()->json(['message' => 'User Tidak Ditemukan'], 404);
        }

        // dd($user);

        $data = [
            'id' => $user->id,
            'nama' => $user->name,
            'foto' => $user->foto,
            'email' => $user->email,
            // 'password'=>$user->password,
            'tanggal_lahir' => $user->tanggal_lahir,
            'kota_asal' => $user->kota,
        ];

        return response()->json(['user' => $data], 200);
    }

    public function updateUser($id, Request $request)
    {

        $user = User::find($id);

        $request->validate([
            'name' => 'required',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $image_name = str_replace(' ', '_', $request->name) . '.' . $image->getClientOriginalExtension();

            Storage::delete('images/users/' . basename($user->foto));

            $image->move(public_path('images/users'), $image_name);

            $user->update([
                'name' => $request->name,
                'foto' => $image_name,
                'password' => Hash::make($request->password),
                'tanggal_lahir' => $request->tanggal_lahir,
                'kota_asal' => $request->kota_asal,
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'tanggal_lahir' => $request->tanggal_lahir,
                'kota_asal' => $request->kota_asal,
            ]);
        }

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'foto' => $user->foto,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'kota_asal' => $user->kota->kota,
        ];


        return response()->json(['message' => 'Berhasil Mengupdate User', 'user' => $data], 201);
    }

    public function hapusUser($id)
    {
        dd(User::find($id));
        User::where($id,'id')->delete();
        return response()->json(['message' => 'Berhasil Menghapus User'], 200);
    }
}
