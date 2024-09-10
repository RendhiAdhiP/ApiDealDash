<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $request->only('email', 'password');


        if (Auth::attempt($user)) {

            $token = $request->user()->createToken('token')->plainTextToken;

            return response()->json([
                'message' => 'Selamat Datang ' . $request->user()->name,
                'user' => [
                    'name' => $request->user()->name,
                    'foto' => $request->user()->foto,
                    'email' => $request->user()->email,
                    'token' => $token
                ],
            ], 201);
        }

        return response()->json(['message' => 'Invalid email or password'], 400);
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Berhasil Logout'], 200);
    }
}
