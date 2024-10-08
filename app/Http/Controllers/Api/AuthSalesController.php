<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthSalesController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = $request->only('email', 'password');

            if (Auth::attempt($user)) {

                if($request->user()->isSales()){

                    $token = $request->user()->createToken('token')->plainTextToken;
    
                    $data = [
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        'role' => $request->user()->role->name,
                        'token' => $token
                    ];
    
                    return ApiResponse::success('Selamat Datang ' . $request->user()->name, $data, 201);
                }

                return ApiResponse::error('Forbidden', 403);
            }

            return ApiResponse::error('Invalid email or password', 400);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return ApiResponse::success('Berhasil Logout', [], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
        }
    }
}
