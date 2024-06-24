<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'jadwal_kelas_id',
        'pertemuan',
        'siswas_id',
        'status'
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
