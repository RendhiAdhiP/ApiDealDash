<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManajemenUserController extends Controller
{
    public function index()
    {

        try {
            $users = User::with('kota')->paginate(10);

            $data = $users->toArray();

           
            $data['data'] = collect($data['data'])->map(function ($u) {
                return [
                    'id' => $u['id'],
                    'nama' => $u['name'],
                    'email' => $u['email'],
                    'asal_kota' => $u['kota']['kota'],
                ];
            });

            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
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

        try {

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

            return ApiResponse::success('Berhasil Menambahkan User', $data, 201);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }


    public function detailUser($id, Request $request)
    {

        try {
            $user = User::find($id);

            if (!$user) {
                return ApiResponse::error('User Tidak Ditemukan', 404);
            }

            $data = [
                'id' => $user->id,
                'nama' => $user->name,
                'foto' => $user->foto,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'kota_asal' => $user->kota->kota,
            ];

            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function editUser($id, Request $request)
    {

        try {
            $user = User::with('kota')->find($id);

            if (!$user) {
                return ApiResponse::error('User Tidak Ditemukan', 404);
            }


            $data = [
                'id' => $user->id,
                'nama' => $user->name,
                'foto' => $user->foto,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'kota_asal' => $user->kota,
            ];

            return ApiResponse::success('', $data, 200);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function updateUser($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg',
            'email' => 'required|email|unique:users,email,' . $id,
            'tanggal_lahir' => 'required|date',
            'kota_asal' => 'required',
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                return ApiResponse::error('User Tidak Ditemukan', 404);
            }


            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'min:8',
                ]);
            }

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image_name = str_replace(' ', '_', $request->name) . '.' . $image->getClientOriginalExtension();

                Storage::delete('images/users/' . basename($user->foto));

                $image->move(public_path('images/users'), $image_name);

                if ($request->password) {
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }
                $user->update([
                    'name' => $request->name,
                    'foto' => $image_name,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'kota_asal' => $request->kota_asal,
                ]);
            } else {

                if ($request->password) {
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }

                $user->update([
                    'name' => $request->name,
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
                'password' => $request->password,
            ];


            return ApiResponse::success('Berhasil Mengupdate User', $data, 201);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }

    public function hapusUser($id)
    {

        try {
            $user = User::find($id);

            if (!$user) {
                return ApiResponse::error('User Tidak Ditemukan', 404);
            }

            $user->delete();

            return ApiResponse::success('Berhasil Menghapus User', [], 200);
        } catch (\Exception $e) {

            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }
}
