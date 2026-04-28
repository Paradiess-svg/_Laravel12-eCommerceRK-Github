@extends('layouts.admin')

@section('content')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center"><a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Admin</a></li>
          <li><div class="flex items-center"><i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i><span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Hero & Banner</span></div></li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Manajemen Hero Banner</h1>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-300" role="alert"><span class="font-medium">Berhasil!</span> {{ session('success') }}</div>
    @endif
    @if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-300" role="alert"><span class="font-bold">Gagal Menyimpan!</span><ul class="mt-1 list-disc list-inside">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900"><i class="fas fa-newspaper mr-2"></i>Daftar Hero</h2>
            <button type="button" data-modal-target="tambahModal" data-modal-toggle="tambahModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium"><i class="fas fa-plus mr-1"></i>Tambah Hero</button>
        </div>

        <div class="overflow-x-auto mt-4">
          <table id="heroTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Kode</th>
                <th class="px-6 py-3">Foto</th>
                <th class="px-6 py-3">Judul</th>
                <th class="px-6 py-3">Deskripsi</th>
                <th class="px-6 py-3">Link</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($heroes as $hero)
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-medium">{{ $hero->kode_hero }}</td>
                <td class="px-6 py-4">
                    @if($hero->foto) <img src="{{ asset('storage/' . $hero->foto) }}" class="w-24 h-14 object-cover rounded shadow-sm"> @else <span class="text-xs text-gray-400">No Img</span> @endif
                </td>
                <td class="px-6 py-4 font-bold">{{ $hero->judul }}</td>
                <td class="px-6 py-4 truncate max-w-xs" title="{{ $hero->deskripsi }}">{{ Str::limit($hero->deskripsi, 50) }}</td>
                <td class="px-6 py-4 text-blue-600 truncate max-w-xs"><a href="{{ $hero->link }}" target="_blank">{{ $hero->link }}</a></td>
                <td class="px-6 py-4">
                    @if($hero->status == 'aktif') <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                    @elseif($hero->status == 'promo') <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Promo</span>
                    @elseif($hero->status == 'laris') <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Terlaris</span>
                    @else <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Nonaktif</span> @endif
                </td>
                <td class="px-6 py-4 text-center flex justify-center gap-2">
                    <button type="button" onclick="editHero(
                            '{{ $hero->id }}', '{{ $hero->kode_hero }}', '{{ $hero->judul }}', '{{ str_replace(["\r", "\n"], " ", addslashes($hero->deskripsi)) }}', 
                            '{{ $hero->link }}', '{{ $hero->status }}', '{{ $hero->foto ? asset('storage/' . $hero->foto) : '' }}'
                        )" class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="deleteHero('{{ route('hero.destroy', $hero->id) }}')" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>

    <div id="tambahModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Hero</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="tambahModal"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                </div>
                <form action="{{ route('hero.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Kode Hero</label><input type="text" name="kode_hero" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="H01" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Judul</label><input type="text" name="judul" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="Hero Pertama" required></div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Link (Opsional)</label><input type="text" name="link" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="https://..."></div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Foto Banner</label><p class="text-sm text-gray-500 mb-2"><i class="fas fa-info-circle"></i> <b>Perhatian!</b> Unggah foto/icon maksimal 10 MB dan hanya tipe file PNG/JPG.</p><input name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" type="file" required></div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select name="status" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                <option value="aktif">Aktif (Slider)</option><option value="promo">Promo</option><option value="laris">Terlaris</option><option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label><textarea name="deskripsi" rows="3" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"></textarea></div>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center"><i class="fas fa-plus mr-2"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div id="editModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Hero</h3>
                    <button type="button" onclick="editModalInstance.hide()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                </div>
                <form id="form-edit" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="flex justify-center mb-4"><div class="w-64 h-32 bg-gray-100 rounded-lg shadow overflow-hidden"><img id="edit-foto-preview" src="" class="w-full h-full object-cover"></div></div>
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Kode Hero</label><input type="text" id="edit-kode" name="kode_hero" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Judul</label><input type="text" id="edit-judul" name="judul" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required></div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Link</label><input type="text" id="edit-link" name="link" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"></div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Ganti Foto (Opsional)</label><p class="text-sm text-gray-500 mb-2"><i class="fas fa-info-circle"></i> <b>Perhatian!</b> Unggah foto/icon maksimal 10 MB dan hanya tipe file PNG/JPG.</p><input name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" type="file"></div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select id="edit-status" name="status" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                <option value="aktif">Aktif</option><option value="promo">Promo</option><option value="laris">Terlaris</option><option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label><textarea id="edit-deskripsi" name="deskripsi" rows="3" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"></textarea></div>
                    </div>
                    <button type="submit" class="text-white bg-yellow-400 hover:bg-yellow-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center"><i class="fas fa-save mr-2"></i> Update</button>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <button type="button" onclick="deleteModalInstance.hide()" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
            <i class="fas fa-exclamation-triangle text-gray-400 text-5xl mb-3"></i>
            <p class="mb-4 text-gray-500">Yakin hapus banner ini?</p>
            <div class="flex justify-center items-center space-x-4">
              <button type="button" onclick="deleteModalInstance.hide()" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Batal</button>
              <form id="delete-form" method="POST" action="">@csrf @method('DELETE')<button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700">Ya, Hapus</button></form>
            </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let editModalInstance = null;
    let deleteModalInstance = null;

    $(document).ready(function () { 
        $('#heroTable').DataTable({ responsive: true });

        // Manual JS Init
        const editModalEl = document.getElementById('editModal');
        const deleteModalEl = document.getElementById('deleteModal');
        if (window.Modal) {
            editModalInstance = new window.Modal(editModalEl);
            deleteModalInstance = new window.Modal(deleteModalEl);
        }
    });

    function editHero(id, kode, judul, deskripsi, link, status, fotoUrl) {
        document.getElementById('form-edit').action = '/hero/' + id;
        document.getElementById('edit-kode').value = kode;
        document.getElementById('edit-judul').value = judul;
        document.getElementById('edit-deskripsi').value = deskripsi;
        document.getElementById('edit-link').value = (link == '#' || link == null) ? '' : link;
        document.getElementById('edit-status').value = status;

        let img = document.getElementById('edit-foto-preview');
        if (fotoUrl && fotoUrl.length > 10) {
            img.src = fotoUrl;
        } else {
            img.src = "{{ asset('assets/images/RatuKom_hitam.png') }}";
        }
        img.onerror = function() { this.src = "{{ asset('assets/images/RatuKom_hitam.png') }}"; };
        
        if(editModalInstance) editModalInstance.show();
    }

    function deleteHero(url) { 
        document.getElementById('delete-form').action = url; 
        if(deleteModalInstance) deleteModalInstance.show();
    }
</script>
@endpush