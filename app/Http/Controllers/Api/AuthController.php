<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'noHp' => 'required|exists:users,noHp',
                'password' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
    
            $data = $request->only('noHp', 'password');
    
            if(!$token = auth()->guard('api')->attempt($data)){
                return response()->json([
                    'success' => false,
                    'message' => 'noHp atau password salah'
                ], 400);
            }
    
            return response()->json([
                'success' => true,
                'user' => auth()->guard('api')->user(),
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ],500);
        }
    }

    public function logout() {
        try {
            $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
            
            if($removeToken) {
                return response()->json([
                    'success' => true,
                    'mesaage' => 'Logout Berhasil'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ],500);
        }
        
    }
}
