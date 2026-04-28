@extends('layouts.frontend')

@section('title', 'Simulasi Rakit PC - Ratu Komputer')

@section('content')

@if(session('wa_link'))
<script>
    window.open("{{ session('wa_link') }}", "_blank");
</script>
@endif

<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Simulasi Rakit PC</h1>

    <form action="{{ route('simulasi.store') }}" method="POST" id="rakit-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8"> <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-slate-700 text-white rounded-lg p-6 shadow-lg">
                    <h2 class="text-lg font-semibold mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-yellow-400"></i> Instruksi
                    </h2>
                    <hr class="border-slate-500 my-2">
                    <p class="text-sm leading-relaxed text-gray-200">
                        Pilih komponen dari <b>Cabang Pusat (Serang)</b>. Pilih komponen yang tertera di dropdown, jika komponen tidak dipilih, akan dianggap kosong (-). 
                        Anda dapat menentukan jumlah (Qty) per item (Max 5). Komponen yang disimulasikan mungkin tak akurat karena kompabilitas, oleh karena itu pentingnya berkonsultasi. Simulasi hanya akan tersimpan secara otomatis jika anda menekan tombol "Segera Konsultasi".
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 space-y-6 border border-gray-100">
                    <div class="p-4 bg-blue-50 border border-blue-100 flex justify-between items-center rounded-lg">
                        <h3 class="font-semibold text-blue-800">Sumber Produk</h3>
                        <span class="font-bold text-xs bg-blue-200 text-blue-800 px-3 py-1 rounded-full">Gudang Pusat (Serang)</span>
                    </div>

                    @php
                        $komponen = [
                            ['label' => 'Processor',   'key' => 'Prosessor',    'name' => 'processor'],
                            ['label' => 'Motherboard', 'key' => 'Motherboard',  'name' => 'motherboard'],
                            ['label' => 'RAM',         'key' => 'RAM',          'name' => 'ram'],
                            ['label' => 'Casing',      'key' => 'Casing',       'name' => 'casing'],
                            ['label' => 'SSD',         'key' => 'SSD',          'name' => 'ssd'],
                            ['label' => 'HDD',         'key' => 'HDD',          'name' => 'hdd'],
                            ['label' => 'VGA',         'key' => 'VGA',          'name' => 'vga'],
                            ['label' => 'PSU',         'key' => 'PSU',          'name' => 'psu'],
                            ['label' => 'Mouse',       'key' => 'Mouse',        'name' => 'mouse'],
                            ['label' => 'Keyboard',    'key' => 'Keyboard',     'name' => 'keyboard'],
                            ['label' => 'Monitor',     'key' => 'Monitor',      'name' => 'monitor'],
                            ['label' => 'Cooler Fan',  'key' => 'Cooler Fan',   'name' => 'coolerfan'],
                        ];
                    @endphp

                    @foreach($komponen as $k)
                    <div class="grid grid-cols-12 gap-3 items-center border-b border-gray-100 pb-4 last:border-0 item-row">
                        <label class="col-span-12 md:col-span-3 font-medium text-gray-700">{{ $k['label'] }}</label>
                        
                        <div class="col-span-8 md:col-span-5">
                            <select name="{{ $k['name'] }}" class="component-select w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                <option value="" data-price="0">Pilih {{ $k['label'] }}</option>
                                @if(isset($products[$k['key']]))
                                    @foreach($products[$k['key']] as $prod)
                                        <option value="{{ $prod->nama }}" data-price="{{ $prod->harga }}">
                                            {{ $prod->nama }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-span-4 md:col-span-2 flex items-center justify-center">
                            <div class="flex items-center">
                                <span class="text-xs text-gray-400 mr-1 ">x</span>
                                <input type="number" name="qty_{{ $k['name'] }}" value="1" min="1" max="5" 
                                       class="component-qty w-14 text-center text-sm border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-2 flex justify-end items-center">
                            <input type="text" class="price-display w-full text-right font-bold text-gray-800 bg-transparent border-none focus:ring-0 p-0 text-sm" value="Rp 0" readonly>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-5 self-start space-y-6 transition-all duration-300">
                    
                    <div class="bg-white rounded-lg shadow-md p-4 flex justify-center">
                        <img src="{{ asset('assets/images/fotopc.png') }}" alt="Gaming PC" class="w-64 h-auto object-cover rounded-lg hover:scale-105 transition duration-300">
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-slate-700">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Simulasi</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                <span class="text-gray-600">Kode Simulasi</span>
                                <span class="font-mono font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">AUTO</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-bold">Grand Total</span>
                                <span id="grand-total-display" class="text-2xl font-extrabold text-red-600">Rp 0</span>
                            </div>
                        </div>
                        
                        <input type="hidden" name="grand_total_hidden" id="grand-total-hidden" value="0">

                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center gap-2 shadow-md transform active:scale-95">
                            <i class="fa-brands fa-whatsapp text-xl"></i> Segera Konsultasi
                        </button>
                        
                        <p class="text-xs text-gray-400 text-center mt-3 italic">*Harga estimasi & belum termasuk jasa rakit</p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const itemRows = document.querySelectorAll('.item-row');
        const grandTotalDisplay = document.getElementById('grand-total-display');
        const grandTotalInput = document.getElementById('grand-total-hidden');

        // Formatter
        const formatRupiah = (number) => {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        };

        function calculateTotal() {
            let total = 0;

            itemRows.forEach(row => {
                const select = row.querySelector('.component-select');
                const qtyInput = row.querySelector('.component-qty');
                const priceDisplay = row.querySelector('.price-display');

                // Ambil Harga & Qty
                const selectedOption = select.options[select.selectedIndex];
                const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
                let qty = parseInt(qtyInput.value) || 1;

                // Validasi Qty (1-5)
                if(qty < 1) qty = 1;
                if(qty > 5) qty = 5;
                // qtyInput.value = qty; // Optional: Auto koreksi input user

                // Hitung Subtotal per baris
                const subTotal = price * qty;

                // Update Tampilan Harga Per Baris
                priceDisplay.value = formatRupiah(subTotal);

                total += subTotal;
            });

            // Update Grand Total
            grandTotalDisplay.innerText = formatRupiah(total);
            grandTotalInput.value = total;
        }

        // Pasang Event Listener di Select DAN Input Qty
        itemRows.forEach(row => {
            const select = row.querySelector('.component-select');
            const qtyInput = row.querySelector('.component-qty');

            select.addEventListener('change', calculateTotal);
            qtyInput.addEventListener('input', calculateTotal);
            qtyInput.addEventListener('change', calculateTotal);
        });
    });
</script>
@endpush