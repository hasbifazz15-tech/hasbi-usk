<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserPendaftaranController;
use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Support\Facades\Route;

// Welcome
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login dan Register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});

// Dashboard dan fitur Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        $totalPeserta = Peserta::count();
        $totalSkema = Skema::count();

        $pesertaLulus = Peserta::where('status', 'Lulus')->count();

        $pesertaProses = Peserta::where('status', 'Proses')->count();

        return view('dashboard', compact(
            'totalPeserta',
            'totalSkema',
            'pesertaLulus',
            'pesertaProses'
        ));
    })->name('dashboard');

    Route::resource('skema', SkemaController::class);

    Route::resource('peserta', PesertaController::class)
        ->parameters(['peserta' => 'peserta']);
});

// Dashboard dan fitur User
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard User
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // Profil User
    Route::get('/user/profil', [UserDashboardController::class, 'profile'])
        ->name('user.profil');

    // Update nama, email, NIK, dan nomor HP
    Route::put('/user/profil', [UserDashboardController::class, 'updateProfile'])
        ->name('user.profil.update');

    // Ganti password
    Route::put('/user/profil/password', [
        UserDashboardController::class,
        'updatePassword'
    ])->name('user.profil.password');

    // Daftar skema
    Route::get('/user/skema', [UserPendaftaranController::class, 'index'])
        ->name('user.skema.index');

    // Form pendaftaran skema
    Route::get('/user/skema/{skema}/daftar', [
        UserPendaftaranController::class,
        'create'
    ])->name('user.skema.daftar');

    // Simpan pendaftaran
    Route::post('/user/pendaftaran', [
        UserPendaftaranController::class,
        'store'
    ])->name('user.pendaftaran.store');

    // Riwayat pendaftaran
    Route::get('/user/pendaftaran', [
        UserPendaftaranController::class,
        'riwayat'
    ])->name('user.pendaftaran');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');