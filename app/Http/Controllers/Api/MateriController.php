<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Http\Requests\StoreMateriRequest;
use App\Http\Requests\UpdateMateriRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materi = Materi::all();
        return response()->json([
            'success' => true,
            'message' => "Berhasil mendapatkan data",
            'user'    => $materi,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string',
                'deskripsi' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $materi = Materi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ]);

            if($materi) {
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menyimpan data",
                    'materi' => $materi,
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string',
                'deskripsi' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $materi->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ]);

            if($materi) {
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil mengupdate data",
                    'materi' => $materi,
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        try {
            $materi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ],500);
        }
    }
}
