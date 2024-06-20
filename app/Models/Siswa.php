<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'noIdentitas',
        'nama',
        'noTelp',
        'jadwal_kelas_id'
    ];
    protected $primaryKey = 'noIdentitas';

}
