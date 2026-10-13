<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skema extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'lembaga',
    ];

    public function pesertas(): HasMany
    {
        return $this->hasMany(Peserta::class);
    }
}