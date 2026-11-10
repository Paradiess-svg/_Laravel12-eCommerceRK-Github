<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SimulasiController;

/*
|--------------------------------------------------------------------------
| Admin (butuh login)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    // 1. Data Statistik
    $karyawanCount = App\Models\User::where('role', '!=', 'owner')->count();
    $kategoriCount = App\Models\Kategori::count();
    $cabangCount = App\Models\Cabang::count();

    // 2. Data Tabel
    $simulasiTerbaru = App\Models\RakitPc::latest()->take(5)->get();
    $karyawanTerbaru = App\Models\User::latest()->take(5)->get();

    // 3. Data untuk Dropdown Modal
    $cabangs = App\Models\Cabang::all();

    return view('dashboard', compact(
        'karyawanCount',
        'kategoriCount',
        'cabangCount',
        'simulasiTerbaru',
        'karyawanTerbaru',
        'cabangs'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hanya route yang benar-benar dipakai. create/show/edit tidak tersedia
    // supaya tidak ada halaman 500 karena method controller-nya tidak ada.
    Route::resource('produk', ProdukController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('karyawan', KaryawanController::class)->only(['store', 'update', 'destroy']);
    Route::get('/karyawan', fn () => redirect()->route('dashboard'));
    Route::resource('cabang', CabangController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('hero', HeroController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('kategori', KategoriController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::delete('/simulasi/{id}', [SimulasiController::class, 'destroy'])->name('simulasi.destroy');
});

// Halaman profil admin (wajib login, kalau sesi habis diarahkan ke halaman login)
Route::get('/profil', function () {
    $user = Illuminate\Support\Facades\Auth::user();

    if (! $user) {
        return redirect()->route('login')
            ->withErrors(['session' => 'Sesi kamu sudah habis. Silakan login kembali.']);
    }

    return view('admin.profil.index', compact('user'));
})->middleware('auth')->name('profil');

/*
|--------------------------------------------------------------------------
| Frontend (publik)
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/katalog', [FrontendController::class, 'katalog'])->name('katalog');
Route::get('/detail-produk/{id}', [FrontendController::class, 'detail'])->name('produk.detail');

// Route Search (Redirect ke katalog)
Route::get('/search', [FrontendController::class, 'katalog'])->name('search');

// Simulasi Rakit PC
Route::get('/simulasi', [SimulasiController::class, 'index'])->name('simulasi.index');
Route::post('/simulasi', [SimulasiController::class, 'store'])->name('simulasi.store');

require __DIR__.'/auth.php';
