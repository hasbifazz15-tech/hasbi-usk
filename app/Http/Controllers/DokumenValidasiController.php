<?php

namespace App\Http\Controllers;

use App\Models\DokumenPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DokumenValidasiController extends Controller
{
    // Daftar dokumen
    public function index()
    {
        $dokumen = DokumenPeserta::with('peserta')
            ->latest()
            ->paginate(10);

        $jumlahMenunggu = DokumenPeserta::where(
            'status',
            'menunggu'
        )->count();

        return view(
            'admin.validasi.index',
            compact('dokumen', 'jumlahMenunggu')
        );
    }

    // Detail dokumen
    public function show(DokumenPeserta $dokumen)
    {
        $dokumen->load('peserta');

        return view('admin.validasi.show', compact('dokumen'));
    }

   

// Menampilkan file dokumen yang diunggah peserta
public function file(DokumenPeserta $dokumen)
{
    $path = $dokumen->file_path;

    abort_unless(
        $path && Storage::disk('local')->exists($path),
        404,
        'File dokumen tidak ditemukan.'
    );

    $file = Storage::disk('local')->path($path);

    return response()->file($file, [
        'Content-Type' => Storage::disk('local')->mimeType($path)
            ?? 'application/octet-stream',
        'X-Content-Type-Options' => 'nosniff',
    ]);
}

    // Validasi keputusan admin
    public function konfirmasi(
        Request $request,
        DokumenPeserta $dokumen
    ) {
        $data = $request->validate([
            'keputusan' => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        if ($dokumen->status !== 'menunggu') {
            return back()->with(
                'error',
                'Dokumen ini sudah divalidasi.'
            );
        }

        if (
            $data['keputusan'] === 'ditolak'
            && blank($data['catatan_admin'] ?? null)
        ) {
            return back()
                ->withErrors([
                    'catatan_admin' =>
                        'Alasan penolakan wajib diisi.',
                ])
                ->withInput();
        }

        session([
            'validasi_dokumen' => [
                'id' => $dokumen->id,
                'keputusan' => $data['keputusan'],
                'catatan_admin' => $data['catatan_admin'] ?? null,
            ],
        ]);

        return redirect()->route('admin.validasi.konfirmasi');
    }

    // Halaman konfirmasi sebelum keputusan disimpan
    public function halamanKonfirmasi()
    {
        $data = session('validasi_dokumen');

        if (!$data) {
            return redirect()
                ->route('admin.validasi.index')
                ->with(
                    'error',
                    'Tidak ada keputusan untuk dikonfirmasi.'
                );
        }

        $dokumen = DokumenPeserta::with('peserta')
            ->findOrFail($data['id']);

        if ($dokumen->status !== 'menunggu') {
            session()->forget('validasi_dokumen');

            return redirect()
                ->route('admin.validasi.index')
                ->with('error', 'Dokumen sudah divalidasi.');
        }

        return view(
            'admin.validasi.konfirmasi',
            compact('dokumen', 'data')
        );
    }

    // Simpan keputusan dan perbarui status peserta
    public function simpanKonfirmasi()
    {
        $data = session('validasi_dokumen');

        if (!$data) {
            return redirect()
                ->route('admin.validasi.index')
                ->with(
                    'error',
                    'Sesi konfirmasi sudah berakhir.'
                );
        }

        $berhasil = DB::transaction(function () use ($data) {
            $dokumen = DokumenPeserta::query()
                ->lockForUpdate()
                ->findOrFail($data['id']);

            if ($dokumen->status !== 'menunggu') {
                return false;
            }

            $dokumen->update([
                'status' => $data['keputusan'],
                'catatan_admin' => $data['catatan_admin'] ?? null,
                'diverifikasi_oleh' => Auth::id(),
                'diverifikasi_pada' => now(),
            ]);

            $peserta = $dokumen->peserta()->first();

            if ($peserta) {
                $jumlahDokumen = $peserta
                    ->dokumenPesertas()
                    ->count();

                $semuaDiterima = $jumlahDokumen > 0
                    && !$peserta->dokumenPesertas()
                        ->where('status', '!=', 'diterima')
                        ->exists();

                $peserta->status_verifikasi = $semuaDiterima
                    ? 'Terverifikasi'
                    : 'Belum Terverifikasi';

                $peserta->save();
            }

            return true;
        });

        session()->forget('validasi_dokumen');

        if (!$berhasil) {
            return redirect()
                ->route('admin.validasi.index')
                ->with(
                    'error',
                    'Dokumen sudah divalidasi sebelumnya.'
                );
        }

        return redirect()
            ->route('admin.validasi.index')
            ->with('success', 'Dokumen berhasil divalidasi.');
    }
}