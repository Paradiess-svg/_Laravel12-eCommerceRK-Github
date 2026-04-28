@extends('layouts.frontend')

@section('title', 'Katalog - Ratu Komputer')

@section('content')

<div class="bg-gray-50 py-8">
    <div class="w-[95%] md:w-[90%] mx-auto flex flex-col lg:flex-row gap-8">

        <div class="lg:hidden w-full mb-4">
            <button id="mobile-filter-btn" class="w-full bg-slate-700 text-white py-3 rounded-lg font-bold shadow-md flex justify-center items-center gap-2">
                <i class="fa-solid fa-filter"></i> Filter & Urutkan
            </button>
        </div>

        <aside id="sidebar-filter" class="hidden lg:block w-full lg:w-1/4 bg-white p-6 rounded-xl shadow-md h-fit sticky top-24 z-40 lg:z-auto transition-all">
            <div class="lg:hidden flex justify-between items-center mb-6 pb-4 border-b">
                <h3 class="text-xl font-bold text-slate-700">Filter Produk</h3>
                <button id="close-filter-btn" class="text-gray-500 hover:text-red-500"><i class="fa-solid fa-xmark text-2xl"></i></button>
            </div>

            <form action="{{ route('katalog') }}" method="GET" id="filter-form">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

                <div class="mb-8">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <img class="w-5" src="{{ asset('assets/images/Katalog.png') }}" alt="icon"> Kategori
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center p-2 rounded hover:bg-gray-50">
                            <input id="cat-all" type="checkbox" name="kategori[]" value="semua" 
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer"
                                {{ !request('kategori') || in_array('semua', (array)request('kategori')) ? 'checked' : '' }}
                                onchange="handleKategoriChange(this, 'all'); this.form.submit()">
                            <label for="cat-all" class="ms-3 text-sm font-medium text-gray-900 cursor-pointer w-full">Semua Kategori</label>
                        </li>

                        @foreach($kategoris as $kat)
                        <li class="flex items-center p-2 rounded hover:bg-gray-50">
                            <input id="cat-{{ $kat->id }}" type="checkbox" name="kategori[]" value="{{ $kat->id }}" 
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer category-item"
                                {{ in_array($kat->id, (array)request('kategori')) ? 'checked' : '' }}
                                onchange="handleKategoriChange(this, 'item'); this.form.submit()">
                            <label for="cat-{{ $kat->id }}" class="ms-3 text-sm font-medium text-gray-900 cursor-pointer w-full">{{ $kat->nama }}</label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <hr class="my-6">

                <div class="mb-8">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-slate-700"></i> Lokasi
                    </h3>
                    <select name="cabang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" onchange="this.form.submit()">
                        <option value="semua">Semua Lokasi</option>
                        @foreach($cabangs as $cab)
                            <option value="{{ $cab->id }}" {{ request('cabang') == $cab->id ? 'selected' : '' }}>{{ $cab->nama }}</option>
                        @endforeach
                    </select>
                </div>
            
        </aside>

        <div class="w-full lg:w-3/4">
            
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm mb-6 border border-gray-100">
                <div class="mb-4 md:mb-0 flex items-center gap-2">
                    @if(request('q'))
                        <p class="text-gray-700">Menampilkan hasil pencarian: <span class="font-bold text-blue-600">"{{ request('q') }}"</span></p>
                        <a href="{{ route('katalog') }}" class="text-red-500 hover:text-red-700 bg-red-100 hover:bg-red-200 rounded-full w-6 h-6 flex items-center justify-center" title="Hapus Pencarian">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </a>
                    @else
                        <p class="text-gray-700 font-medium">Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} produk</p>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-gray-700 whitespace-nowrap">Urutkan:</span>
                    <select name="sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" onchange="document.getElementById('filter-form').submit()">
                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </div>
                </form> </div>

            @if($produks->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($produks as $prod)
                <a href="{{ route('produk.detail', $prod->id) }}">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl hover:scale-[1.02] transition duration-300 flex flex-col h-full border border-gray-100">
                        <div class="bg-white h-48 flex items-center justify-center p-4 relative group">
                            <img class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-110" 
                                 src="{{ $prod->foto ? asset('storage/' . $prod->foto) : asset('assets/images/RatuKom_hitam.png') }}" 
                                 alt="{{ $prod->nama }}">
                            
                            @if($prod->stok < 5 && $prod->stok > 0)
                                <span class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Sisa {{ $prod->stok }}!</span>
                            @elseif($prod->stok == 0)
                                <div class="absolute inset-0 bg-gray-900/50 flex items-center justify-center">
                                    <span class="bg-red-600 text-white font-bold px-3 py-1 rounded shadow-lg transform -rotate-12">HABIS</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-grow flex flex-col justify-between bg-slate-50">
                            <div>
                                <h3 class="text-gray-900 font-bold text-base leading-tight line-clamp-2 mb-1" title="{{ $prod->nama }}">{{ $prod->nama }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-2 mb-2">{{ $prod->deskripsi }}</p>
                            </div>
                            <div>
                                <p class="text-lg font-extrabold text-red-600">Rp {{ number_format($prod->harga, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-1 mt-2 text-slate-600 font-medium">
                                    <i class="fa-solid fa-location-dot text-xs"></i>
                                    <span class="text-xs">{{ $prod->cabang->nama ?? 'Gudang' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $produks->links() }}
            </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-sm text-center">
                    <img src="{{ asset('assets/images/RatuKom_hitam.png') }}" class="w-32 opacity-50 mb-4 grayscale">
                    <h3 class="text-xl font-bold text-gray-600">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500">Coba ganti kata kunci atau reset filter kamu.</p>
                    <a href="{{ route('katalog') }}" class="mt-4 text-blue-600 font-bold hover:underline">Reset Filter</a>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function handleKategoriChange(checkbox, type) {
        const allCheckbox = document.getElementById('cat-all');
        const itemCheckboxes = document.querySelectorAll('.category-item');

        if (type === 'all') {
            if (checkbox.checked) {
                itemCheckboxes.forEach(cb => cb.checked = false);
            }
        } else {
            if (checkbox.checked) {
                allCheckbox.checked = false;
            } else {
                let anyChecked = false;
                itemCheckboxes.forEach(cb => { if(cb.checked) anyChecked = true; });
                if(!anyChecked) allCheckbox.checked = true;
            }
        }
    }

    const mobileBtn = document.getElementById('mobile-filter-btn');
    const closeBtn = document.getElementById('close-filter-btn');
    const sidebar = document.getElementById('sidebar-filter');

    mobileBtn.addEventListener('click', () => {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('fixed', 'inset-0', 'bg-white', 'z-50', 'p-6', 'overflow-y-auto');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('fixed', 'inset-0', 'bg-white', 'z-50', 'p-6', 'overflow-y-auto');
    });
</script>
@endpush