<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Cabang;
use App\Models\RakitPc;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KaryawanController; // <-- Pastikan ini ada di paling atas file!
use App\Http\Controllers\CabangController; // Jangan lupa use
use App\Http\Controllers\HeroController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KategoriController;

// Ini buat FE Pelanggan
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SimulasiController;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // 1. Data Statistik
    $karyawanCount = App\Models\User::where('role', '!=', 'owner')->count();
    $kategoriCount = App\Models\Kategori::count();
    $cabangCount = App\Models\Cabang::count();

    // 2. Data Tabel
    $simulasiTerbaru = App\Models\RakitPc::latest()->take(5)->get();
    $karyawanTerbaru = App\Models\User::latest()->take(5)->get();

    // 3. Data untuk Dropdown Modal (INI YANG TADI KELUPAAN)
    $cabangs = App\Models\Cabang::all(); 

    return view('dashboard', compact(
        'karyawanCount', 
        'kategoriCount', 
        'cabangCount', 
        'simulasiTerbaru', 
        'karyawanTerbaru',
        'cabangs' // <--- Wajib ada biar modal gak error
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('produk', ProdukController::class);
    // Data karyawan dikelola lewat modal di Dashboard, jadi cuma store/update/destroy
    Route::resource('karyawan', KaryawanController::class)->only(['store', 'update', 'destroy']);
    Route::get('/karyawan', fn () => redirect()->route('dashboard'));
    Route::resource('cabang', CabangController::class);
    Route::resource('hero', HeroController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('kategori', KategoriController::class);
    Route::delete('/simulasi/{id}', [App\Http\Controllers\SimulasiController::class, 'destroy'])->name('simulasi.destroy');
    
});

// Route khusus Profil (wajib login, kalau sesi habis diarahkan ke halaman login)
Route::get('/profil', function () {
    $user = Illuminate\Support\Facades\Auth::user();
    return view('admin.profil.index', compact('user'));
})->middleware('auth')->name('profil');

// === FRONTEND ROUTES (PUBLIC) ===
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/katalog', [FrontendController::class, 'katalog'])->name('katalog');
// Ganti kata 'produk' jadi 'detail-produk' biar gak bentrok sama admin
Route::get('/detail-produk/{id}', [FrontendController::class, 'detail'])->name('produk.detail');

// Route Search (Redirect ke katalog)
Route::get('/search', [FrontendController::class, 'katalog'])->name('search');

// Ini untuk Simulasi Rakit PC
Route::get('/simulasi', [SimulasiController::class, 'index'])->name('simulasi.index');
Route::post('/simulasi', [SimulasiController::class, 'store'])->name('simulasi.store');

require __DIR__.'/auth.php';
