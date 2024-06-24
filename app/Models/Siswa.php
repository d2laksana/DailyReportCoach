<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function jadwalKelas(): BelongsTo
    {
        return $this->belongsTo(JadwalKelas::class);
    }
}
