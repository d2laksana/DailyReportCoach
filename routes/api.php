<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JadwalKelasController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [UsersController::class, 'store']);


// resources
Route::apiResource('users', UsersController::class)->middleware(AuthMiddleware::class);
Route::apiResource('materi', MateriController::class)->middleware(AuthMiddleware::class);
Route::apiResource('jadwal', JadwalKelasController::class)->middleware(AuthMiddleware::class);
Route::apiResource('siswa', SiswaController::class)->middleware(AuthMiddleware::class);
Route::apiResource('absensi', AbsensiController::class)->middleware(AuthMiddleware::class);

Route::get('getabsen', [AbsensiController::class, 'filterAbsen'])->middleware(AuthMiddleware::class);
Route::get('getjadwaltoday', [JadwalKelasController::class, 'getJadwalToday'])->middleware(AuthMiddleware::class);
Route::get('search-siswa', [SiswaController::class, 'searchSiswa'])->middleware(AuthMiddleware::class);
