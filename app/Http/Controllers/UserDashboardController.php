<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    // Halaman profil
    public function profile()
    {
        $user = Auth::user();

        $peserta = Peserta::where('email', $user->email)->first();

        return view('user.profil', compact('user', 'peserta'));
    }

    // Simpan perubahan profil dan NIK
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
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
        ]);

        $peserta = Peserta::where('email', $user->email)->first();

        if (!$peserta) {
            return back()->withErrors([
                'nik' => 'Data peserta belum ditemukan. Silakan daftar skema terlebih dahulu.',
            ])->withInput();
        }

        $duplikat = Peserta::where('nik', $data['nik'])
            ->where('id', '!=', $peserta->id)
            ->exists();

        if ($duplikat) {
            return back()->withErrors([
                'nik' => 'NIK sudah digunakan peserta lain.',
            ])->withInput();
        }

        $emailLama = $user->email;

        $user->name = $data['name'];
        $user->email = $data['email'];
        

        $peserta->nama = $data['name'];
        $peserta->email = $data['email'];
        $peserta->nik = $data['nik'];
        $peserta->no_hp = $data['no_hp'] ?? '';
        $peserta->save();

        Peserta::where('email', $emailLama)
            ->where('id', '!=', $peserta->id)
            ->update(['email' => $data['email']]);

        return back()->with(
            'profile_success',
            'Profil dan NIK berhasil diperbarui.'
        );
    }

    // Ganti password
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with(
            'password_success',
            'Password berhasil diganti.'
        );
    }
}