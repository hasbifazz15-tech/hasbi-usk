<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserPendaftaranController;
use App\Http\Controllers\UserDokumenController;
use App\Http\Controllers\DokumenValidasiController;
use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Support\Facades\Route;

// WELCOME
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// LOGIN: di luar middleware guest
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// REGISTER DAN PROSES LOGIN
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        $totalPeserta = Peserta::count();
        $totalSkema = Skema::count();
        $pesertaLulus = Peserta::where('status', 'Lulus')->count();
        $pesertaProses = Peserta::whereIn('status', [
            'Proses',
            'Terdaftar',
        ])->count();

        return view('dashboard', compact(
            'totalPeserta',
            'totalSkema',
            'pesertaLulus',
            'pesertaProses'
        ));
    })->name('dashboard');

    Route::resource('skema', SkemaController::class);

    Route::resource('peserta', PesertaController::class)
        ->parameters(['peserta' => 'peserta'])
        ->except(['create', 'store']);

    Route::patch('/peserta/{peserta}/status', [
        PesertaController::class,
        'updateStatus',
    ])->name('peserta.updateStatus');

    Route::get('/validasi-dokumen', [
        DokumenValidasiController::class,
        'index',
    ])->name('admin.validasi.index');

    Route::get('/validasi-dokumen/konfirmasi', [
        DokumenValidasiController::class,
        'halamanKonfirmasi',
    ])->name('admin.validasi.konfirmasi');

    Route::post('/validasi-dokumen/konfirmasi', [
        DokumenValidasiController::class,
        'simpanKonfirmasi',
    ])->name('admin.validasi.simpan-konfirmasi');

    Route::get('/validasi-dokumen/{dokumen}/file', [
        DokumenValidasiController::class,
        'file',
    ])->name('admin.validasi.file');

    Route::post('/validasi-dokumen/{dokumen}/keputusan', [
        DokumenValidasiController::class,
        'konfirmasi',
    ])->name('admin.validasi.keputusan');

    Route::get('/validasi-dokumen/{dokumen}', [
        DokumenValidasiController::class,
        'show',
    ])->name('admin.validasi.show');
});

// PESERTA
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [
        UserDashboardController::class,
        'index',
    ])->name('user.dashboard');

    Route::get('/user/profil', [
        UserDashboardController::class,
        'profile',
    ])->name('user.profil');

    Route::put('/user/profil', [
        UserDashboardController::class,
        'updateProfile',
    ])->name('user.profil.update');

    Route::put('/user/profil/password', [
        UserDashboardController::class,
        'updatePassword',
    ])->name('user.profil.password');

    Route::get('/user/skema', [
        UserPendaftaranController::class,
        'index',
    ])->name('user.skema.index');

    Route::get('/user/skema/{skema}/daftar', [
        UserPendaftaranController::class,
        'create',
    ])->name('user.skema.daftar');

    Route::post('/user/pendaftaran', [
        UserPendaftaranController::class,
        'store',
    ])->name('user.pendaftaran.store');

    Route::get('/user/pendaftaran', [
        UserPendaftaranController::class,
        'riwayat',
    ])->name('user.pendaftaran');

    Route::get('/user/dokumen', [
        UserDokumenController::class,
        'index',
    ])->name('user.dokumen.index');

    Route::post('/user/dokumen', [
        UserDokumenController::class,
        'store',
    ])->name('user.dokumen.store');
});

// LOGOUT
Route::post('/logout', [
    AuthController::class,
    'logout',
])->middleware('auth')->name('logout');