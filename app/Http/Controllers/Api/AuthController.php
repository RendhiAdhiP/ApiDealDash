<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){


        $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);
        
        $user = $request->only('email', 'password');

        $email = User::where('email', $request->email)->first();

        if(!$email){
            return response()->json(['message'=>'user not registered'], 404);
        }else{

            if(Auth::attempt($user)){

                $token = $request->user()->createToken('token')->plainTextToken;
    
                return response()->json([
                    'name'=>$request->user()->name,
                    'email'=>$request->user()->email,
                    'token'=>$token,
                ], 201);
            }
    
            return response()->json(['message' => 'Invalid email or password'], 400);
        }

    }

    public function logout(Request $request){

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
