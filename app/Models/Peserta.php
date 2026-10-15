<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    // Relasi ke skema sertifikasi
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }

    // Relasi ke dokumen peserta
    public function dokumenPesertas(): HasMany
    {
        return $this->hasMany(DokumenPeserta::class, 'peserta_id');
    }
}