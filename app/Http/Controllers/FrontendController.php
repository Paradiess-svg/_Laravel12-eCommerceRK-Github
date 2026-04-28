<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Cabang;  // Penting biar ga error Class not found
use App\Models\Gallery;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // 1. HOMEPAGE
    public function index()
    {
        // Hero Slider (Status: aktif)
        $heroes = Hero::where('status', 'aktif')->latest()->get();
        
        // Kategori (Semua Kategori)
        $kategoris = Kategori::all();

        // Popular Section (Promo & Terlaris)
        $promoHero = Hero::where('status', 'promo')->latest()->first();
        $larisHero = Hero::where('status', 'laris')->latest()->first();

        // Rekomendasi Produk (Random 8 item)
        $rekomendasi = Produk::with('cabang')->inRandomOrder()->take(8)->get();

        return view('frontend.home', compact(
            'heroes', 
            'kategoris', 
            'promoHero', 
            'larisHero', 
            'rekomendasi'
        ));
    }

    // 2. KATALOG (FILTER CANGGIH & SORTING)
    public function katalog(Request $request)
    {
        $query = Produk::with(['kategori', 'cabang']); // Eager load biar ringan

        // A. SEARCH PINTAR (Cari di Nama Produk, Nama Kategori, atau Nama Cabang)
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhereHas('kategori', function($k) use ($keyword) {
                      $k->where('nama', 'like', '%' . $keyword . '%');
                  })
                  ->orWhereHas('cabang', function($c) use ($keyword) {
                      $c->where('nama', 'like', '%' . $keyword . '%');
                  });
            });
        }

        // B. FILTER KATEGORI (Checkbox Array)
        if ($request->filled('kategori')) {
            $kategoriIds = $request->kategori;
            // Kalau user centang sesuatu dan itu bukan "semua"
            if (is_array($kategoriIds) && !in_array('semua', $kategoriIds)) {
                $query->whereIn('id_kategori', $kategoriIds);
            }
        }

        // C. FILTER CABANG (Lokasi)
        if ($request->filled('cabang') && $request->cabang != 'semua') {
            $query->where('id_cabang', $request->cabang);
        }

        // D. SORTING (Urutan)
        $sort = $request->get('sort', 'termurah');
        switch ($sort) {
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'a-z':
                $query->orderBy('nama', 'asc');
                break;
            case 'z-a':
                $query->orderBy('nama', 'desc');
                break;
            case 'terbaru':
                $query->latest();
                break;
            case 'terlama':
                $query->oldest();
                break;
            default: // termurah
                $query->orderBy('harga', 'asc');
                break;
        }

        // E. EKSEKUSI (Pagination 12 item)
        $produks = $query->paginate(12)->withQueryString();
        
        // Data Pendukung View
        $kategoris = Kategori::all();
        $cabangs = Cabang::all();

        return view('frontend.katalog', compact('produks', 'kategoris', 'cabangs'));
    }

    // 3. DETAIL PRODUK (Akan kita kerjakan setelah ini)
    public function detail($id)
    {
        $produk = Produk::with(['kategori', 'cabang', 'gallery'])->findOrFail($id);
        
        // Produk Terkait (Satu Kategori, tapi bukan produk yang sedang dilihat)
        $related = Produk::where('id_kategori', $produk->id_kategori)
                         ->where('id', '!=', $id)
                         ->take(4)
                         ->get();

        return view('frontend.detail', compact('produk', 'related'));
    }
}