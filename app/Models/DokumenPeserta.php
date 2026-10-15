<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenPeserta extends Model
{
    protected $fillable = [
        'peserta_id',
        'jenis_dokumen',
        'file_path',
        'status',
        'catatan_admin',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected function casts(): array
    {
        return [
            'diverifikasi_pada' => 'datetime',
        ];
    }

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'diverifikasi_oleh'
        );
    }
}