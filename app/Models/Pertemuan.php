<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pertemuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pertemuan_ke',
        'jadwal_kelas_id'
    ];

    public function jadwalKelas(): HasOne
    {
        return $this->hasOne(JadwalKelas::class);
    }
}
