<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peserta extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'email',
        'no_hp',
        'alamat',
        'skema_id',
        'tanggal_daftar',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }
}