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
        'pertemuans_id',
        'siswas_id',
        'status'
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
