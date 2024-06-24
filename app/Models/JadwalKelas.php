<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function materis(): BelongsTo
    {
        return $this->belongsTo(Materi::class);
    }
}
