<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pertemuan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
                'siswa.*.siswas_id' => 'required|exists:siswas,noIdentitas',
                'siswa.*.status' => 'required',
                'ulasan' => 'required',
                'pertemuan_ke' => 'required',
                'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // save data pertemuan
            $cekPertemuan = DB::table('pertemuans')
                ->where('pertemuan_ke', '=', $request->pertemuan_ke)
                ->where('jadwal_kelas_id', '=', $request->jadwal_kelas_id)
                ->first();

            $pertemuanId = '';

            if (!$cekPertemuan) {
                $pertemuan = new Pertemuan();
                $pertemuan->pertemuan_ke = $request->pertemuan_ke;
                $pertemuan->jadwal_kelas_id = $request->jadwal_kelas_id;
                $pertemuan->save();
                $pertemuanId = $pertemuan->id;
            } else {
                $pertemuanId = $cekPertemuan->id;
            }
            // dataAbsensi Siswa
            $dataAbsensi = $request->input('siswa');

            // Cek Data Absensi 
            $cekDataAbsensi = Absensi::where('pertemuans_id', $pertemuanId)->get();



            if (count($cekDataAbsensi) != 0) {

                foreach ($dataAbsensi as &$item) {
                    // dd($item['siswas_id']);
                    // dd($cekDataAbsensi);
                    $absenSiswa = Absensi::where('siswas_id', $item['siswas_id'])
                        ->where('pertemuans_id', $pertemuanId)
                        ->first();

                    if ($absenSiswa) {
                        $absenSiswa->update([
                            'status' => $item['status']
                        ]);
                    } else {
                        $absenBaru = Absensi::create([
                            'pertemuans_id' => $pertemuanId,
                            'siswas_id' => $item['siswas_id'],
                            'status' => $item['status']
                        ]);
                    }
                }

                $ulasan = Ulasan::where('pertemuans_id', $pertemuanId);

                if ($ulasan) {
                    $ulasan->update([
                        'deskripsi' => $request->ulasan
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menyimpan data absensi',
                    'data' => [
                        'Absensi' => $dataAbsensi,
                        'Ulasan' => $request->ulasan,
                        'Pertemuan_ke' => $request->pertemuan_ke
                    ]
                ], 200);
            }

            foreach ($dataAbsensi as &$item) {
                $item['pertemuans_id'] = $pertemuanId;
            }

            $absenSiswa = Absensi::insert($dataAbsensi);

            // save data ulasan
            $ulasan = Ulasan::create([
                'deskripsi' => $request->ulasan,
                'pertemuans_id' => $pertemuanId
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan data absensi',
                'data' => [
                    'Absensi' => $dataAbsensi,
                    'Ulasan' => $request->ulasan,
                    'Pertemuan_ke' => $request->pertemuan_ke
                ]
            ], 200);
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
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        //
    }

    public function filterAbsen(Request $request)
    {
        // nama siswa, kelas, staus presensi, ulasan
        try {
            $validator = Validator::make($request->all(), [
                'pertemuan_ke' => 'required',
                'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $cekDataAbsensi = DB::table('absensis')
                ->select('absensis.*')
                ->join('pertemuans', 'absensis.pertemuans_id', '=', 'pertemuans.id')
                ->where('pertemuans.pertemuan_ke', '=', $request->pertemuan_ke)
                ->where('pertemuans.jadwal_kelas_id', '=', $request->jadwal_kelas_id)
                ->orderBy('absensis.siswas_id',)
                ->get();

            $dataSiswa = DB::table('siswas')
                ->select('siswas.*', 'jadwal_kelas.*')
                ->join('jadwal_kelas', 'siswas.jadwal_kelas_id', '=', 'jadwal_kelas.id')
                ->where('siswas.jadwal_kelas_id', '=', $request->jadwal_kelas_id)
                ->get();

            $dataUlasan = DB::table('ulasans')
                ->select('*')
                ->join('pertemuans', 'ulasans.pertemuans_id', '=', 'pertemuans.id')
                ->where('pertemuans.pertemuan_ke', '=', $request->pertemuan_ke)
                ->where('pertemuans.jadwal_kelas_id', '=', $request->jadwal_kelas_id)
                ->first();

            if (count($cekDataAbsensi) != 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mendapatkan data',
                    'data' => [
                        'absensi' => $cekDataAbsensi,
                        'siswa' => $dataSiswa,
                        'ulasan' => $dataUlasan
                    ]
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data',
                'data' => [
                    'absensi' => $cekDataAbsensi,
                    'siswa' => $dataSiswa,
                    'ulasan' => $dataUlasan
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delDataAbsensi(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pertemuan_ke' => 'required',
                'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $cekDataAbsensi = Absensi::join('pertemuans', 'absensis.pertemuans_id', '=', 'pertemuans.id')
                ->where('pertemuans.pertemuan_ke', '=', $request->pertemuan_ke)
                ->where('pertemuans.jadwal_kelas_id', '=', $request->jadwal_kelas_id)
                ->orderBy('absensis.siswas_id',)
                ->delete();


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
