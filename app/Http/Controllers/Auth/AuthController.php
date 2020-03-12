<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) 
            {
                return response()->json(['error' => 'Cannot Login'], 400);
            }
        } catch (JWTException $e) 
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where('username',$request->username)->first();

        $token = JWTAuth::fromUser($user);
        return response()->json([
            "code" => 200,
            "status" => "success",
            "data"=> compact('user','token')
            ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:255',
        ]);

        if($validator->fails()) 
        {
            return response()->json([
                "code" => 400,
                "status" => "failed",
                "message" => "Gagal Mendaftar"
            ]);
        }

        $user = User::create([
            'nama' => $request->get('nama'),
            'username' =>$request->get('username'),
            'password' => Hash::make($request->get('password')),
            'phone' => $request->get('phone'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            "code" => 200,
            "status" => "success",
            "message" => "Berhasil Mendaftar"
        ]);
    }
}
