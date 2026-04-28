@extends('layouts.frontend')

@section('title', 'Home - Ratu Komputer')

@section('content')

    <section class="w-full mt-20">
        <div class="owl-carousel owl-theme" id="hero-carousel">
            @forelse($heroes as $hero)
            <div class="item relative w-full" style="aspect-ratio: 16/5;">
                <a href="{{ $hero->link ? $hero->link : '#' }}" {{ $hero->link && $hero->link != '#' ? 'target="_blank"' : '' }}>
                    <img src="{{ asset('storage/' . $hero->foto) }}" class="w-full h-full object-cover" alt="{{ $hero->judul }}">
                </a>
            </div>
            @empty
            <div class="item relative w-full bg-slate-700 flex items-center justify-center" style="aspect-ratio: 16/5;">
                <h2 class="text-white text-xl md:text-3xl font-bold">Selamat Datang di Ratu Komputer</h2>
            </div>
            @endforelse
        </div>
    </section>

    <section class="bg-slate-700 py-12 md:py-16" id="katalog">
        <div class="w-[90%] mx-auto">
            <div class="flex flex-col md:flex-row text-white items-center justify-center md:justify-start mb-8 gap-4 text-center md:text-left">
                <div class="flex flex-row items-center gap-2.5">
                    <img class="w-12 md:w-16" src="{{ asset('assets/images/catalogwhite.png') }}" alt="Katalog">
                    <h2 class="text-3xl md:text-4xl font-extrabold">KATEGORI PRODUK</h2>
                </div>
                <h2 class="hidden md:block text-4xl font-extrabold mx-2">|</h2>
                <p class="text-sm md:text-xl font-extrabold max-w-lg">Pilih kategori sesuai kebutuhanmu.</p>
            </div>

            <div class="w-full">
                <div class="owl-carousel owl-theme" id="katalog-carousel">
                    @foreach($kategoris as $kategori)
                    <div class="item text-center p-2">
                        <a href="{{ route('katalog', ['kategori[]' => $kategori->id]) }}" class="block hover:scale-90 transition duration-300">
                            <div class="w-20 h-20 mx-auto flex items-center justify-center bg-slate-600 rounded-full mb-2 border-2 border-slate-500 overflow-hidden">
                                @if($kategori->icon)
                                    <img class="!w-12 !h-12 object-contain" src="{{ asset('storage/' . $kategori->icon) }}" alt="{{ $kategori->nama }}">
                                @else
                                    <i class="fa-solid fa-microchip text-3xl text-white"></i>
                                @endif
                            </div>
                            <p class="text-white font-semibold">{{ $kategori->nama }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-100 py-16" id="popular">
        <div class="w-[90%] mx-auto flex flex-col">
            <div class="flex flex-col md:flex-row text-slate-700 items-center justify-center md:justify-start mb-8 gap-4 text-center md:text-left">
                <div class="flex flex-row items-center gap-2.5">
                    <img class="w-12 md:w-16" src="{{ asset('assets/images/Popular.png') }}" alt="Popular">
                    <h2 class="text-3xl md:text-4xl font-extrabold">POPULAR</h2>
                </div>
                <h2 class="hidden md:block text-4xl font-extrabold mx-2">|</h2>
                <div>
                    <p class="text-sm md:text-xl font-extrabold">Laris Manis, Cepat Habis! 🚀</p>
                    <p class="text-sm md:text-xl font-extrabold">Produk favorit paling dicari cuma di Ratu Komputer!</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-start justify-center gap-10 w-full">
                <div class="flex flex-col items-center w-full md:w-1/2">
                    @if($larisHero)
                        <a href="{{ $larisHero->link ? $larisHero->link : '#' }}" {{ $larisHero->link && $larisHero->link != '#' ? 'target="_blank"' : '' }} class="w-full block overflow-hidden rounded-xl shadow-lg hover:scale-95 transition duration-300">
                            <img class="w-full h-auto object-cover" src="{{ asset('storage/' . $larisHero->foto) }}" alt="{{ $larisHero->judul }}">
                        </a>
                    @else
                        <div class="w-full h-64 bg-gray-300 rounded-xl flex items-center justify-center text-gray-500">Belum ada data</div>
                    @endif
                    <p class="text-2xl md:text-3xl font-extrabold mt-4 text-slate-700 text-center">PRODUK TERLARIS</p>
                </div>
                <div class="flex flex-col items-center w-full md:w-1/2">
                    @if($promoHero)
                        <a href="{{ $promoHero->link ? $promoHero->link : '#' }}" {{ $promoHero->link && $promoHero->link != '#' ? 'target="_blank"' : '' }} class="w-full block overflow-hidden rounded-xl shadow-lg hover:scale-95 transition duration-300">
                            <img class="w-full h-auto object-cover" src="{{ asset('storage/' . $promoHero->foto) }}" alt="{{ $promoHero->judul }}">
                        </a>
                    @else
                         <div class="w-full h-64 bg-gray-300 rounded-xl flex items-center justify-center text-gray-500">Belum ada data</div>
                    @endif
                    <p class="text-2xl md:text-3xl font-extrabold mt-4 text-slate-700 text-center">PRODUK SPESIAL PROMO</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-700 min-h-[400px] flex items-center py-10" id="rakitpc">
        <div class="w-[90%] mx-auto gap-8 items-center xl:gap-16 grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col justify-center order-2 md:order-1 text-center"> 
                <div class="flex items-center mb-6 justify-center">
                    <img class="w-12 h-12 mr-4" src="{{ asset('assets/images/RakitPCWhite.png') }}" alt="Ikon Rakit PC">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">Simulasi Rakit PC</h2>
                </div>
                <div class="w-full p-8 bg-white rounded-lg shadow-xl">
                    <h5 class="mb-4 text-xl md:text-2xl font-bold text-gray-900 leading-snug">
                        Mau coba simulasi build<br>Impianmu?
                    </h5>
                    <h5 class="mb-6 text-2xl md:text-3xl font-extrabold text-gray-900">Coba Sekarang!</h5>
                    <a href="{{ url('/simulasi') }}" class="inline-flex items-center px-6 py-3 text-xl font-bold text-white bg-slate-700 rounded-lg hover:bg-slate-600 transition duration-300 shadow-md">
                        <i class="fa-solid fa-arrow-pointer m-2"></i> Klik Disini
                    </a>
                </div>
            </div>
            <div class="w-full h-full order-1 md:order-2 flex justify-center items-center">
                <img class="w-full max-w-lg h-auto object-cover rounded-lg shadow-2xl" 
                     src="{{ asset('assets/images/fotopc.png') }}" alt="PC Rakitan">
            </div>
        </div>
    </section>

    <section class="bg-slate-100 py-16">
        <div class="w-[90%] mx-auto">
            <div class="flex flex-col md:flex-row items-center md:items-start mb-8 text-center md:text-left gap-4">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mr-4 whitespace-nowrap">REKOMENDASI LAINNYA</h2>
                <span class="hidden md:block text-4xl font-extrabold text-slate-700 mr-4">|</span>
                <p class="text-sm md:text-xl font-extrabold text-slate-700 leading-tight">
                    Cek produk rekomendasi dari Ratu Komputer yang siap bantu PC kamu makin cepat!
                </p>
            </div>

            <div class="relative">
                <div id="rekomendasi-carousel" class="owl-carousel owl-theme">
                    @foreach($rekomendasi as $prod)
                    <div class="item p-2 hover:scale-95 transition duration-300">
                        <a href="{{ route('produk.detail', $prod->id) }}">
                            <div class="h-[420px] bg-white rounded-2xl shadow-xl overflow-hidden cursor-pointer flex flex-col">
                                <div class="h-[200px] w-full bg-white flex items-center justify-center p-4">
                                    <img class="max-w-full max-h-full object-contain" 
                                         src="{{ $prod->foto ? asset('storage/' . $prod->foto) : asset('assets/images/RatuKom_hitam.png') }}" 
                                         alt="{{ $prod->nama }}">
                                </div>
                                <div class="flex-grow bg-slate-700 p-4 text-white flex flex-col justify-between">
                                    <div>
                                        <h5 class="mb-1 text-base font-bold judul-potong" title="{{ $prod->nama }}">{{ $prod->nama }}</h5>
                                        <p class="text-xs font-normal text-gray-300 leading-snug deskripsi-potong">{{ Str::limit($prod->deskripsi, 60) }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-2xl font-extrabold leading-none whitespace-nowrap">Rp {{ number_format($prod->harga, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $prod->cabang->nama ?? 'Semua Cabang' }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <button id="prev-slide-btn" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-slate-700 text-white p-3 rounded-full shadow-lg hover:bg-slate-800 z-10"><i class="fa-solid fa-chevron-left"></i></button>
                <button id="next-slide-btn" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-slate-700 text-white p-3 rounded-full shadow-lg hover:bg-slate-800 z-10"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <section class="bg-slate-100 border-t border-gray-200" id="konsultasi">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col justify-center items-center p-12 bg-slate-100">
                <div class="flex flex-col md:flex-row text-slate-700 place-items-center mb-6 text-center md:text-left gap-4">
                    <img class="w-16" src="{{ asset('assets/images/qmark.png') }}" alt="QMark">
                    <div><p class="text-2xl md:text-4xl font-extrabold">Kenapa Pelanggan</p><p class="text-2xl md:text-4xl font-extrabold">Percaya Ratu Komputer?</p></div>
                </div>
                <ul class="text-white w-full md:w-3/4 space-y-4">
                    <li class="text-xl md:text-2xl bg-slate-700 p-3 rounded-xl text-center md:text-left">✅ Produk Lengkap & Original</li>
                    <li class="text-xl md:text-2xl bg-slate-700 p-3 rounded-xl text-center md:text-left">✅ Harga Bersahabat</li>
                    <li class="text-xl md:text-2xl bg-slate-700 p-3 rounded-xl text-center md:text-left">✅ Konsultasi Langsung</li>
                </ul>
            </div>
            <div class="bg-slate-700 flex flex-col items-center justify-center py-12 text-center text-white">
                <p class="text-3xl font-extrabold mb-2">Butuh Konsultasi?</p>
                <p class="text-3xl font-extrabold mb-2">Produk, Service, dan Layanan?</p>
                <p class="text-3xl font-extrabold mb-2">Tanyakan Lebih Lanjut!</p>
                <a href="https://wa.me/6287773599434?text=Halo%20Ratu%20Bagus%20Komputer%2C%20saya%20ingin%20Konsultasi." target="_blank"
                   class="inline-flex items-center bg-green-500 text-white font-extrabold rounded-lg text-xl px-6 py-3 mt-6 hover:bg-green-600 transition shadow-lg">
                    <i class="fa-brands fa-whatsapp mr-2 text-2xl"></i> WhatsApp (Gratis!)
                </a>
            </div>
        </div>
    </section>

    <section id="kontak">
        <div class="grid grid-cols-1 md:grid-cols-2 bg-slate-100">
            <div class="w-full h-[400px]">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.0322922370697!2d106.16193337377858!3d-6.126356860067233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e41f5255b895725%3A0xc22172dcd7ef4a8!2sRatu%20Computer!5e0!3m2!1sid!2sid!4v1763949306831!5m2!1sid!2sid" 
                        class="w-full h-full" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="flex flex-col justify-center text-slate-700 p-10 bg-white">
                <h2 class="font-extrabold text-3xl md:text-4xl">RATU COMPUTER SOLUSI</h2>
                <h2 class="font-extrabold text-3xl md:text-4xl mb-8">KEBUTUHAN PC MU!</h2>
                
                <a href="https://goo.gl/maps/your-real-map-link" target="_blank" class="flex items-start gap-4 mb-6 hover:opacity-80 transition">
                    <img class="w-10" src="{{ asset('assets/images/Location.png') }}" alt="Loc">
                    <div>
                        <p class="text-lg font-bold">Jl. Ciwaru Raya No. RT04/16,</p>
                        <p class="text-lg">Cipare, Kec. Serang, Kota Serang, Banten 42117</p>
                    </div>
                </a>

                <a href="https://wa.me/6287773599434" target="_blank" class="flex items-center gap-4 hover:opacity-80 transition">
                    <img class="w-10" src="{{ asset('assets/images/WhatsApp.png') }}" alt="WA">
                    <p class="text-2xl font-bold">0877-7359-9434</p>
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $("#hero-carousel").owlCarousel({ items: 1, loop: true, nav: false, dots: true, autoplay: true, autoplayTimeout: 5000 });
        $("#katalog-carousel").owlCarousel({ loop: true, margin: 10, nav: false, autoplay: true, responsive: { 0: { items: 3 }, 600: { items: 5 }, 1000: { items: 7 } } });
        var owlRekomen = $("#rekomendasi-carousel");
        owlRekomen.owlCarousel({ loop: true, margin: 20, nav: false, dots: false, autoplay: true, responsive: { 0: { items: 1, stagePadding: 30 }, 600: { items: 2 }, 1000: { items: 4 } } });
        $('#next-slide-btn').click(function() { owlRekomen.trigger('next.owl.carousel'); });
        $('#prev-slide-btn').click(function() { owlRekomen.trigger('prev.owl.carousel'); });
    });
</script>
@endpush