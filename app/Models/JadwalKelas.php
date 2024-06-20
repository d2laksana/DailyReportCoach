<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'hari',
        'materis_id',
        'tempat',
        'mulai',
        'selesai'
    ];
}
