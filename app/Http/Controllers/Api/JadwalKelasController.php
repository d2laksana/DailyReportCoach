<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalKelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jadwalKelass = JadwalKelas::with('materis')->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data',
                'data' => $jadwalKelass
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
                'nama' => 'required|string',
                'hari' => 'required',
                'materis_id' => 'required|exists:materis,id',
                'tempat' => 'required',
                'mulai' => 'required',
                'selesai' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $jadwal = JadwalKelas::create([
                'nama' => $request->nama,
                'hari' => $request->hari,
                'materis_id' => $request->materis_id,
                'tempat' => $request->tempat,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai
            ]);

            if ($jadwal) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menambahkan data',
                    'data' => $jadwal
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
    public function show($id)
    {
        $data = JadwalKelas::find($id);

        if ($data) {
            $jadwalKelas = $data->load('materis');
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data',
                'data' => $jadwalKelas
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
    public function edit(JadwalKelas $jadwalKelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'hari' => 'required',
                'materis_id' => 'required|exists:materis,id',
                'tempat' => 'required',
                'mulai' => 'required',
                'selesai' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $jadwalKelas = JadwalKelas::find($id);

            $jadwalKelas->update([
                'nama' => $request->nama,
                'hari' => $request->hari,
                'materis_id' => $request->materis_id,
                'tempat' => $request->tempat,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai
            ]);
            return response()->json([
                'success' => true,
                'message' => "Berhasil mengupdate data",
                'materi' => $jadwalKelas,
            ], 200);
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
    public function destroy($id)
    {
        try {
            $jadwalKelas = JadwalKelas::find($id);
            // dd(!$jadwalKelas);
            if ($jadwalKelas) {
                $jadwalKelas->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menghapus data'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getJadwalToday()
    {
        try {
            $jadwalToday = DB::table('jadwal_kelas')
                ->where('jadwal_kelas.hari', '=', Carbon::now()->format('l'))
                ->get();

            if (count($jadwalToday) != 0) {
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil mendapatkan data",
                    'data' => $jadwalToday,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
