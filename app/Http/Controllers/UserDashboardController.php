<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $email = Auth::user()->email;

        // Total pendaftaran milik user
        $totalPendaftaran = Peserta::where('email', $email)->count();

        // Total peserta yang lulus
        $totalLulus = Peserta::where('email', $email)
            ->where('status', 'Lulus')
            ->count();

        // Pendaftaran yang masih diproses
        $totalProses = Peserta::where('email', $email)
            ->whereIn('status', ['Proses', 'Terdaftar'])
            ->count();

        // Total skema yang tersedia
        $totalSkema = Skema::count();

        // Riwayat pendaftaran terbaru milik user
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
}
