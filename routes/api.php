<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\JadwalKelasController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UsersController::class);
Route::resource('materi', MateriController::class);
Route::resource('jadwal', JadwalKelasController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('absensi', AbsensiController::class);