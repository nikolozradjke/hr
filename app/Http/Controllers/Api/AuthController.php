<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Requests\ApiLoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(ApiRegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('register_token')->plainTextToken;

        return response()->json([
            'status' => 1,
            'desc' => 'Success',
            'token' => $token
        ]);
    }
    
    public function login(ApiLoginRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => 0,
                'desc' => 'These credentials do not match our records'
            ]);
        }

        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json([
            'status' => 1,
            'desc' => 'Success',
            'token' => $token
        ]);
    }
}
