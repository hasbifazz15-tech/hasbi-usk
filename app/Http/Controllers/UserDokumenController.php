<?php

namespace App\Http\Controllers;

use App\Models\DokumenPeserta;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserDokumenController extends Controller
{
    public function index()
    {
        $pesertas = Peserta::where(
            'email',
            Auth::user()->email
        )->with('dokumenPesertas')->latest()->get();

        return view('user.dokumen', compact('pesertas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peserta_id' => [
                'required',
                'integer',
                Rule::exists('pesertas', 'id')->where(
                    'email',
                    Auth::user()->email
                ),
            ],
            'dokumen' => 'required|array|min:1',
            'dokumen.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'peserta_id.exists' => 'Data pendaftaran tidak ditemukan.',
            'dokumen.required' => 'Pilih dokumen yang ingin diunggah.',
            'dokumen.*.mimes' => 'Dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen.*.max' => 'Ukuran setiap file maksimal 5 MB.',
        ]);

        $peserta = Peserta::where('id', $data['peserta_id'])
            ->where('email', Auth::user()->email)
            ->firstOrFail();

        $jenisDiizinkan = ['ktp', 'ijazah', 'sertifikat'];

        foreach ($request->file('dokumen') as $jenis => $file) {
            if (!in_array($jenis, $jenisDiizinkan, true)) {
                continue;
            }

            $dokumenLama = DokumenPeserta::where('peserta_id', $peserta->id)
                ->where('jenis_dokumen', $jenis)
                ->where('status', 'menunggu')
                ->first();

            if ($dokumenLama) {
                Storage::disk('local')->delete($dokumenLama->file_path);
                $dokumenLama->delete();
            }

            $path = $file->store('dokumen-peserta', 'local');

            DokumenPeserta::create([
                'peserta_id' => $peserta->id,
                'jenis_dokumen' => $jenis,
                'file_path' => $path,
                'status' => 'menunggu',
            ]);
        }

        return redirect()
            ->route('user.dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah dan menunggu pemeriksaan admin.');
    }
}