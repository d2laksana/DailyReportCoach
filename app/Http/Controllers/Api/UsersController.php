<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return response([
            'success' => true,
            'message' => 'Berhasil mendapatkan data users',
            'data' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'noHp' => 'required|unique:users',
                'email' => 'required|unique:users',
                'password' => 'required|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = User::create([
                'name' => $request->name,
                'noHp' => $request->noHp,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user'    => $user,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(users $users)
    {
        //
        return response([
            'success' => true,
            'message' => 'Berhasil mendapatkan data users',
            'data' => $users
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(users $users)
    {
        try {
            $users->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
