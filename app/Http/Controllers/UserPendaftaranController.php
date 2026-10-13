<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPendaftaranController extends Controller
{
    public function index()
    {
        $skemas = Skema::all();

        $skemaTerdaftar = Peserta::where(
            'email', 
            Auth::user()->email
        )->pluck('skema_id')->toArray();

        return view('user.skema.index', compact(
            'skemas',
            'skemaTerdaftar'
        ));
    }

    public function create(Skema $skema)
    {
        $sudahDaftar = Peserta::where('email', Auth::user()->email)
            ->where('skema_id', $skema->id)
            ->exists();

        return view('user.skema.daftar', compact(
            'skema',
            'sudahDaftar'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'skema_id' => 'required|exists:skemas,id',
            'nik' => 'required|digits:16',
            'no_hp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        $sudahDaftar = Peserta::where('email', $user->email)
            ->where('skema_id', $data['skema_id'])
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Kamu sudah mendaftar skema ini.');
        }

        $peserta = new Peserta();
        $peserta->nik = $data['nik'];
        $peserta->nama = $user->name;
        $peserta->email = $user->email;
        $peserta->no_hp = $data['no_hp'];
        $peserta->alamat = $data['alamat'];
        $peserta->skema_id = $data['skema_id'];
        $peserta->tanggal_daftar = now()->toDateString();
        $peserta->status = 'Terdaftar';
        $peserta->save();

        return redirect()->route('user.pendaftaran')
            ->with('success', 'Pendaftaran sertifikasi berhasil dikirim.');
    }

    public function riwayat()
    {
        $pendaftaranSaya = Peserta::with('skema')
            ->where('email', Auth::user()->email)
            ->latest('tanggal_daftar')
            ->get();

        return view('user.pendaftaran', compact('pendaftaranSaya'));
    }
}