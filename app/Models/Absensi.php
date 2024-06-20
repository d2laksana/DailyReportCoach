<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'jadwal_kelas_id',
        'pertemuan',
        'siswas_id',
        'status'
    ];
}
