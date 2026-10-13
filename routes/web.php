
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserPendaftaranController;
use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->role === 'user') {
        return redirect()->route('user.dashboard');
    }

    if (Auth::user()->role === 'admin') {
        return redirect()->route('dashboard');
    }

    Auth::logout();

    return redirect()->route('login');
});

// Login dan Register
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});

// ROUTE ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard admin
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

    // CRUD skema admin
    Route::resource('skema', SkemaController::class);

    // CRUD peserta admin
    Route::resource('peserta', PesertaController::class)
        ->parameters(['peserta' => 'peserta']);
});

// ROUTE USER / PESERTA
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard user
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // Profil user
    Route::get('/user/profil', [UserDashboardController::class, 'profile'])
        ->name('user.profil');

    Route::put('/user/profil', [UserDashboardController::class, 'updateProfile'])
        ->name('user.profil.update');

    // Daftar skema
    Route::get('/user/skema', [UserPendaftaranController::class, 'index'])
        ->name('user.skema.index');

    // Form pendaftaran skema
    Route::get('/user/skema/{skema}/daftar', [UserPendaftaranController::class, 'create'])
        ->name('user.skema.daftar');

    // Simpan pendaftaran
    Route::post('/user/pendaftaran', [UserPendaftaranController::class, 'store'])
        ->name('user.pendaftaran.store');

    // Riwayat pendaftaran
    Route::get('/user/pendaftaran', [UserPendaftaranController::class, 'riwayat'])
        ->name('user.pendaftaran');
});

// Logout admin dan user
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
