<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\RakitPc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SimulasiController extends Controller
{
    public function index()
    {
        // AMBIL PRODUK KHUSUS CABANG SERANG (ID 1)
        // Kita kelompokkan berdasarkan nama kategori biar gampang dipanggil di View
        $products = Produk::where('id_cabang', 1)
            ->where('stok', '>', 0) // Hanya yang ada stok
            ->with('kategori')
            ->get()
            ->groupBy(function($item) {
                return $item->kategori->nama;
            });

        return view('frontend.simulasi', compact('products'));
    }

    public function store(Request $request)
    {
        // Generate Kode Unik
        $kode = 'RK-' . strtoupper(Str::random(5)) . date('d');

        // Helper function biar rapi:
        // Kalau kosong -> "-"
        // Kalau ada -> "Nama Barang (x2)" (Jika qty > 1)
        $formatData = function($field) use ($request) {
            $productName = $request->input($field);
            $qty = $request->input('qty_' . $field, 1); // Ambil qty, default 1
            
            if (!$productName) {
                return '-';
            }
            
            return $qty > 1 ? "$productName (x$qty)" : $productName;
        };

        // Simpan Data
        RakitPc::create([
            'kode_rakitan' => $kode,
            'processor'    => $formatData('processor'),
            'motherboard'  => $formatData('motherboard'),
            'ram'          => $formatData('ram'),
            'casing'       => $formatData('casing'),
            'ssd'          => $formatData('ssd'),
            'hdd'          => $formatData('hdd'),
            'vga'          => $formatData('vga'),
            'psu'          => $formatData('psu'),
            'mouse'        => $formatData('mouse'),
            'keyboard'     => $formatData('keyboard'),
            'monitor'      => $formatData('monitor'),
            'coolerfan'    => $formatData('coolerfan'),
            'total_harga'  => $request->grand_total_hidden
        ]);

        // Siapkan Pesan WA (Ambil data yang sudah diformat tadi)
        // Kita panggil lagi logic formatnya untuk teks WA
        $waNumber = "6287773599434"; 
        
        $rincian = "";
        $fields = ['processor', 'motherboard', 'ram', 'vga', 'psu', 'casing', 'ssd', 'hdd', 'monitor', 'keyboard', 'mouse', 'coolerfan'];
        
        foreach($fields as $f) {
            $val = $formatData($f);
            if($val != '-') {
                $rincian .= "- " . strtoupper($f) . ": $val\n";
            }
        }

        $text = "Halo Ratu Komputer, saya ingin konsultasi hasil simulasi rakit PC:\n\n" .
                "Kode: *$kode*\n" .
                "Total Estimasi: *Rp " . number_format($request->grand_total_hidden, 0, ',', '.') . "*\n\n" .
                "Rincian:\n" . $rincian . "\n" .
                "Mohon dicek ketersediaannya dan kompabilitasnya. Terima kasih!";

        $waLink = "https://wa.me/$waNumber?text=" . urlencode($text);

        return redirect()->route('simulasi.index')->with('wa_link', $waLink);
    }

    // HAPUS SIMULASI (ADMIN)
    public function destroy($id)
    {
        $rakit = RakitPc::findOrFail($id);
        $rakit->delete();
        
        // Redirect ke Dashboard Admin (bukan ke halaman simulasi frontend)
        return redirect()->route('dashboard')->with('success', 'Data simulasi berhasil dihapus!');
    }
}