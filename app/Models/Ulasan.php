<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ulasan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pertemuans_id',
        'deskripsi'
    ];

    public function pertemuan(): HasOne
    {
        return $this->hasOne(Pertemuan::class);
    }
}
