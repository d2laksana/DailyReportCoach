<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dataSiswa = Siswa::with('jadwalKelas')->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data',
                'data' => $dataSiswa
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
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
                'noIdentitas' => 'required|unique:siswas',
                'nama' => 'required|string',
                'noTelp' => 'required',
                'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $siswa = Siswa::create([
                'noIdentitas' => $request->noIdentitas,
                'nama' => $request->nama,
                'noTelp' => $request->noTelp,
                'jadwal_kelas_id' => $request->jadwal_kelas_id
            ]);

            if ($siswa) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menambahkan data',
                    'data' => $siswa
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
    public function show(Siswa $siswa)
    {
        $siswa->load('jadwalKelas');
        if ($siswa) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data',
                'data' => $siswa
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'noTelp' => 'required',
                'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $siswa->update([
                'nama' => $request->nama,
                'noTelp' => $request->noTelp,
                'jadwal_kelas_id' => $request->jadwal_kelas_id
            ]);

            if ($siswa) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengupdate data',
                    'data' => $siswa
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
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
