<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materi extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'deskripsi'
    ];

    public function jadwalKelas(): HasMany
    {
        return $this->hasMany(JadwalKelas::class);
    }
}
