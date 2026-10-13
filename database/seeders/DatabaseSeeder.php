<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skema;
use App\Models\Peserta;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        $skema1 = Skema::create([
            'kode' => 'SKM-001',
            'nama' => 'Junior Web Developer',
            'deskripsi' => 'Sertifikasi kompetensi pengembangan web.',
            'lembaga' => 'LSP',
        ]);

        $skema2 = Skema::create([
            'kode' => 'SKM-002',
            'nama' => 'Programmer',
            'deskripsi' => 'Sertifikasi kompetensi pemrograman.',
            'lembaga' => 'LSP',
        ]);

        Peserta::create([
            'nik' => '3174000000000001',
            'nama' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jakarta',
            'skema_id' => $skema1->id,
            'tanggal_daftar' => now(),
            'status' => 'Terdaftar',
        ]);

        Peserta::create([
            'nik' => '3174000000000002',
            'nama' => 'Andi Saputra',
            'email' => 'andi@gmail.com',
            'no_hp' => '081234567891',
            'alamat' => 'Jakarta',
            'skema_id' => $skema2->id,
            'tanggal_daftar' => now(),
            'status' => 'Proses',
        ]);
    }
}