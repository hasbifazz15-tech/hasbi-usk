<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use App\Models\DokumenPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserDashboardController extends Controller
{
    // Dashboard user
    public function index()
    {
        $email = Auth::user()->email;

        $totalPendaftaran = Peserta::where('email', $email)->count();

        $totalLulus = Peserta::where('email', $email)
            ->where('status', 'Lulus')
            ->count();

        $totalProses = Peserta::where('email', $email)
            ->whereIn('status', ['Proses', 'Terdaftar'])
            ->count();

        $totalSkema = Skema::count();

        $pendaftaranSaya = Peserta::with('skema')
            ->where('email', $email)
            ->latest('tanggal_daftar')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalPendaftaran',
            'totalLulus',
            'totalProses',
            'totalSkema',
            'pendaftaranSaya'
        ));
    }

    // Profil dan status dokumen
    public function profile()
    {
        $user = Auth::user();

        $peserta = Peserta::with('dokumenPesertas')
            ->where('email', $user->email)
            ->latest('id')
            ->first();

        return view('user.profil', compact('user', 'peserta'));
    }

    // Simpan profil sekaligus upload dokumen
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'nik' => ['required', 'digits:16'],
            'no_hp' => ['nullable', 'string', 'max:20'],

            'ktp' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'ijazah' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'sertifikat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            '*.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG.',
            '*.max' => 'Ukuran setiap dokumen maksimal 2 MB.',
        ]);

        $peserta = Peserta::where('email', $user->email)->first();

        if (!$peserta) {
            return back()
                ->withErrors([
                    'nik' => 'Data peserta belum ditemukan. Daftar skema terlebih dahulu.',
                ])
                ->withInput();
        }

        $duplikat = Peserta::where('nik', $data['nik'])
            ->where('id', '!=', $peserta->id)
            ->exists();

        if ($duplikat) {
            return back()
                ->withErrors([
                    'nik' => 'NIK sudah digunakan peserta lain.',
                ])
                ->withInput();
        }

        $jenisDokumen = [
            'ktp' => 'ktp',
            'ijazah' => 'ijazah',
            'sertifikat' => 'sertifikat',
        ];

        $fileBaru = [];

        try {
            DB::transaction(function () use (
                $user,
                $peserta,
                $data,
                $request,
                $jenisDokumen,
                &$fileBaru
            ) {
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->save();

                $peserta->nama = $data['name'];
                $peserta->email = $data['email'];
                $peserta->nik = $data['nik'];
                $peserta->no_hp = $data['no_hp'] ?? '';
                $peserta->save();

                foreach ($jenisDokumen as $field => $jenis) {
                    if (!$request->hasFile($field)) {
                        continue;
                    }

                    $dokumenLama = DokumenPeserta::where(
                        'peserta_id',
                        $peserta->id
                    )
                        ->where('jenis_dokumen', $jenis)
                        ->where('status', 'menunggu')
                        ->first();

                    $path = $request->file($field)
                        ->store('dokumen-peserta', 'local');

                    $fileBaru[] = $path;

                    if ($dokumenLama) {
                        Storage::disk('local')->delete(
                            $dokumenLama->file_path
                        );

                        $dokumenLama->delete();
                    }

                    DokumenPeserta::create([
                        'peserta_id' => $peserta->id,
                        'jenis_dokumen' => $jenis,
                        'file_path' => $path,
                        'status' => 'menunggu',
                        'catatan_admin' => null,
                    ]);
                }

                if (count($fileBaru) > 0) {
                    $peserta->status_verifikasi = 'Belum Terverifikasi';
                    $peserta->save();
                }
            });
        } catch (\Throwable $e) {
            foreach ($fileBaru as $path) {
                Storage::disk('local')->delete($path);
            }

            throw $e;
        }

        return redirect()
            ->route('user.profil')
            ->with(
                'profile_success',
                count($fileBaru) > 0
                    ? 'Profil dan dokumen berhasil disimpan. Dokumen menunggu verifikasi admin.'
                    : 'Profil berhasil diperbarui.'
            );
    }

    // Ganti password
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()
            ->route('user.profil')
            ->with('password_success', 'Password berhasil diganti.');
    }
}