@extends('layouts.frontend')

@section('title', $produk->nama . ' - Ratu Komputer')

@section('content')

    <div class="bg-gray-100 py-4">
        <div class="w-[90%] mx-auto">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center"><a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-gray-400 text-xs mx-2"></i><a href="{{ route('katalog') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Katalog</a></div></li>
                    <li aria-current="page"><div class="flex items-center"><i class="fa-solid fa-chevron-right text-gray-400 text-xs mx-2"></i><span class="text-sm font-medium text-gray-500 truncate max-w-[200px]">{{ $produk->nama }}</span></div></li>
                </ol>
            </nav>
        </div>
    </div>

    <main class="py-6 md:py-10">
        <div class="max-w-screen-xl mx-auto px-4 space-y-8">

            <div class="bg-white p-4 md:p-6 rounded-xl shadow-lg flex flex-col lg:flex-row gap-8 lg:gap-10">
                
                <div class="w-full lg:w-4/12 flex flex-col items-center">
                    <div class="relative group w-full mb-4">
                        <input type="checkbox" id="mainimg" class="peer hidden">
                        <label for="mainimg" class="block overflow-hidden rounded-lg border border-gray-200 cursor-pointer bg-white p-2 h-80 flex items-center justify-center">
                            <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : asset('assets/images/RatuKom_hitam.png') }}" class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105">
                        </label>
                        <div class="hidden peer-checked:flex fixed inset-0 z-[9999] bg-black/90 justify-center items-center backdrop-blur-sm p-4 animate-fade-in">
                            <label for="mainimg" class="absolute inset-0 cursor-zoom-out"></label>
                            <div class="relative max-w-4xl w-full max-h-screen flex justify-center">
                                <label for="mainimg" class="absolute -top-10 right-0 text-white text-3xl cursor-pointer">&times;</label>
                                <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : asset('assets/images/RatuKom_hitam.png') }}" class="max-w-full max-h-[90vh] rounded-lg object-contain">
                            </div>
                        </div>
                    </div>

                    @if($produk->gallery->count() > 0)
                    <div class="grid grid-cols-4 gap-2 w-full">
                        @foreach($produk->gallery as $gal)
                        <div class="relative group">
                            <input type="checkbox" id="gal-{{ $gal->id }}" class="peer hidden">
                            <label for="gal-{{ $gal->id }}" class="block overflow-hidden rounded-lg border border-gray-200 cursor-pointer h-20 flex items-center justify-center hover:border-blue-500">
                                <img src="{{ asset('storage/' . $gal->foto) }}" class="max-w-full max-h-full object-contain">
                            </label>
                            <div class="hidden peer-checked:flex fixed inset-0 z-[9999] bg-black/90 justify-center items-center backdrop-blur-sm p-4">
                                <label for="gal-{{ $gal->id }}" class="absolute inset-0 cursor-zoom-out"></label>
                                <div class="relative max-w-4xl w-full text-center">
                                    <label for="gal-{{ $gal->id }}" class="absolute -top-10 right-0 text-white text-3xl cursor-pointer">&times;</label>
                                    <img src="{{ asset('storage/' . $gal->foto) }}" class="w-full max-h-[80vh] object-contain rounded-lg mb-2">
                                    <p class="text-white font-medium">{{ $gal->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="w-full lg:w-5/12 space-y-4">
                    <div class="flex items-start justify-between gap-2">
                        <h1 id="product-title" class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">{{ $produk->nama }}</h1>
                        
                        <div class="flex gap-3 shrink-0">
                            <button id="copy-title-btn" class="text-gray-500 hover:text-blue-600 transition p-1" title="Copy Nama">
                                <i class="fas fa-copy text-lg"></i>
                            </button>
                            <a id="google-search-btn" href="#" target="_blank" class="text-gray-500 hover:text-blue-600 transition p-1" title="Cari di Google">
                                <i class="fa-brands fa-google text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <p id="unit-price" class="text-3xl font-extrabold text-red-600 border-b pb-4">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <div class="text-sm md:text-base text-gray-700 space-y-2">
                        <div class="grid grid-cols-2 gap-2 bg-gray-50 p-3 rounded-lg">
                            <p class="font-semibold">Kode: <span id="product-code" class="font-normal text-slate-600">{{ $produk->kode_produk }}</span></p>
                            <p class="font-semibold">Kategori: <span class="font-normal text-slate-600">{{ $produk->kategori->nama ?? '-' }}</span></p>
                            <p class="font-semibold">Cabang: <span class="font-normal text-slate-600">{{ $produk->cabang->nama ?? '-' }}</span></p>
                            <p class="font-semibold">Stok: <span id="stock-display" class="font-bold {{ $produk->stok > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $produk->stok > 0 ? $produk->stok : 'Habis' }}</span></p>
                        </div>

                        <div class="pt-4">
                            <h3 class="font-bold text-lg mb-2">Deskripsi Produk:</h3>
                            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-3/12">
                    <div class="border border-gray-200 rounded-xl p-5 shadow-sm bg-gray-50 sticky top-24">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3 hidden lg:block">Ringkasan Belanja</h4>
                        <p id="total-price-display" class="text-2xl font-bold text-red-600 mb-4">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                        @if($produk->stok > 0)
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-sm font-medium text-gray-700">Jumlah</label>
                                <div class="flex items-center gap-2">
                                    <button onclick="updateQty(-1)" class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300 font-bold">-</button>
                                    <input type="number" id="quantity" value="1" min="1" max="{{ $produk->stok }}" class="w-16 p-1.5 border border-gray-300 rounded-md text-center text-sm focus:ring-blue-500 focus:border-blue-500" onchange="validateQty()">
                                    <button onclick="updateQty(1)" class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300 font-bold">+</button>
                                </div>
                            </div>
                            <p id="msg-error" class="text-xs text-red-500 text-right mb-2 hidden">Stok maksimal!</p>

                            <div class="space-y-3">
                                <button id="btn-buy" class="w-full py-3 rounded-lg font-bold bg-green-600 text-white hover:bg-green-700 transition shadow-md flex justify-center items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-xl"></i> Beli Sekarang
                                </button>
                                <button id="btn-ask" class="w-full py-3 rounded-lg font-bold bg-slate-700 text-white hover:bg-slate-600 transition shadow-md flex justify-center items-center gap-2">
                                    <i class="fa-regular fa-comment-dots"></i> Konsultasi Dulu
                                </button>
                            </div>
                        @else
                            <div class="bg-red-100 text-red-700 p-3 rounded-lg text-center font-bold mb-4">Stok Habis</div>
                            <button disabled class="w-full py-3 rounded-lg font-bold bg-gray-400 text-white cursor-not-allowed">Tidak Tersedia</button>
                        @endif

                        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-center">
                            <button id="btn-copy-link" class="text-sm text-slate-500 hover:text-blue-600 flex items-center gap-2 transition">
                                <i class="fa-solid fa-link"></i> <span id="text-copy">Salin Link Produk</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4 mt-12">
                <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                    <h2 class="text-xl font-bold text-gray-900">Produk Terkait</h2>
                    <a href="{{ route('katalog') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                </div>

                @if($related->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($related as $rel)
                        <a href="{{ route('produk.detail', $rel->id) }}">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl hover:scale-[1.02] transition duration-300 flex flex-col h-full border border-gray-100">
                                <div class="bg-white h-40 flex items-center justify-center p-4 relative group">
                                    <img class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-110" 
                                         src="{{ $rel->foto ? asset('storage/' . $rel->foto) : asset('assets/images/RatuKom_hitam.png') }}" 
                                         alt="{{ $rel->nama }}">
                                </div>
                                <div class="p-4 flex-grow flex flex-col justify-between bg-slate-50">
                                    <div><h3 class="text-gray-900 font-bold text-sm leading-tight line-clamp-2 mb-1" title="{{ $rel->nama }}">{{ $rel->nama }}</h3></div>
                                    <div>
                                        <p class="text-base font-extrabold text-red-600">Rp {{ number_format($rel->harga, 0, ',', '.') }}</p>
                                        <div class="flex items-center gap-1 mt-1 text-slate-600 font-medium">
                                            <i class="fa-solid fa-location-dot text-xs"></i><span class="text-xs">{{ $rel->cabang->nama ?? 'Gudang' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 bg-white rounded-xl shadow-sm text-center border border-gray-100">
                        <img src="{{ asset('assets/images/RatuKom_hitam.png') }}" class="w-24 opacity-40 mb-4 grayscale">
                        <h3 class="text-lg font-bold text-gray-600">Tidak Ada Produk Terkait</h3>
                        <p class="text-gray-500 text-sm mb-4">Tetapi masih ada produk-produk yang lain kok!</p>
                        <a href="{{ route('katalog', ['kategori[]' => $produk->id_kategori]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-sm transition shadow-md">
                            Cari yang lain!
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection

@push('scripts')
<script>
    // KONFIGURASI NOMOR WA
    const waNumber = "6287773599434"; 

    // Data Produk
    const maxStock = {{ $produk->stok }};
    const unitPrice = {{ $produk->harga }};
    const productName = "{{ $produk->nama }}";
    const productCode = "{{ $produk->kode_produk }}";
    // TAMBAHAN: Ambil Nama Cabang
    const productBranch = "{{ $produk->cabang->nama ?? 'Gudang Pusat' }}";

    // Elemen DOM
    const qtyInput = document.getElementById('quantity');
    const totalPriceDisplay = document.getElementById('total-price-display');
    const msgError = document.getElementById('msg-error');

    // Formatter Rupiah
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    };

    // 1. Logic Update Qty
    function updateQty(change) {
        let currentQty = parseInt(qtyInput.value);
        if (isNaN(currentQty)) currentQty = 1;

        let newQty = currentQty + change;
        
        if (newQty < 1) newQty = 1;
        if (newQty > maxStock) {
            newQty = maxStock;
            msgError.classList.remove('hidden');
        } else {
            msgError.classList.add('hidden');
        }

        qtyInput.value = newQty;
        updateTotalPrice(newQty);
    }

    function validateQty() {
        updateQty(0);
    }

    // 2. Update Harga Total
    function updateTotalPrice(qty) {
        const total = unitPrice * qty;
        totalPriceDisplay.innerText = formatRupiah(total);
    }

    // 3. Tombol Beli (WhatsApp) - UPDATE FORMAT PESAN
    const btnBuy = document.getElementById('btn-buy');
    if(btnBuy){
        btnBuy.addEventListener('click', function() {
            const qty = qtyInput.value;
            const total = totalPriceDisplay.innerText;
            
            const text = `Halo Ratu Bagus Komputer, saya ingin memesan produk:\n\n` +
                         `*${productName}*\n` +
                         `Kode: ${productCode}\n` +
                         `Cabang: ${productBranch}\n` + // <--- DATA CABANG MASUK SINI
                         `Jumlah: ${qty} pcs\n` +
                         `Total Harga: ${total}\n\n` +
                         `Mohon info pembayaran dan pengirimannya. Terima kasih!`;
            
            window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(text)}`, '_blank');
        });
    }

    // 4. Tombol Tanya (WhatsApp) - UPDATE FORMAT PESAN
    const btnAsk = document.getElementById('btn-ask');
    if(btnAsk){
        btnAsk.addEventListener('click', function() {
            const text = `Halo Ratu Bagus Komputer, saya ingin bertanya tentang produk:\n\n` +
                         `*${productName}*\n` +
                         `Kode: ${productCode}\n` +
                         `Cabang: ${productBranch}\n\n` + // <--- DATA CABANG MASUK SINI
                         `Apakah stok masih tersedia? Saya tertarik dengan produk ini dan ingin mengetahui spesifikasi lengkapnya secara lebih jelas.`;
            
            window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(text)}`, '_blank');
        });
    }

    // 5. Copy Link
    const btnCopy = document.getElementById('btn-copy-link');
    const textCopy = document.getElementById('text-copy');
    if(btnCopy){
        btnCopy.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href);
            let oriText = textCopy.innerText;
            textCopy.innerText = "Link Tersalin!";
            setTimeout(() => { textCopy.innerText = oriText; }, 2000);
        });
    }

    // 6. Copy Nama Produk
    const btnCopyTitle = document.getElementById('copy-title-btn');
    if(btnCopyTitle) {
        btnCopyTitle.addEventListener('click', function() {
            navigator.clipboard.writeText(productName).then(() => {
                const icon = this.querySelector('i');
                icon.className = "fas fa-check text-green-500 text-lg";
                setTimeout(() => {
                    icon.className = "fas fa-copy text-lg";
                }, 1500);
            });
        });
    }

    // 7. Google Search
    const googleBtn = document.getElementById('google-search-btn');
    if(googleBtn) {
        googleBtn.href = `https://www.google.com/search?q=${encodeURIComponent(productName + ' ' + productCode)}`;
    }
</script>
@endpush