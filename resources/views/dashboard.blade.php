@extends('layouts.admin')

@section('content')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">Admin</a>
          </li>
          <li>
            <div class="flex items-center">
              <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
              <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Dasbor</span>
            </div>
          </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Halo, {{ Auth::user()->name }}!</h1>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-300" role="alert">
        <span class="font-medium">Berhasil!</span> {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-300" role="alert">
        <span class="font-medium">Gagal!</span> Periksa inputan:
        <ul class="list-disc list-inside mt-1">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm font-medium mb-1">Karyawan</p>
              <p class="text-3xl font-bold text-gray-900">{{ $karyawanCount }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3"><i class="fas fa-users text-blue-600 text-2xl"></i></div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm font-medium mb-1">Kategori Produk</p>
              <p class="text-3xl font-bold text-gray-900">{{ $kategoriCount }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3"><i class="fa-solid fa-list text-green-600 text-2xl"></i></div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm font-medium mb-1">Total Cabang</p>
              <p class="text-3xl font-bold text-gray-900">{{ $cabangCount }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3"><i class="fa-solid fa-location-dot text-purple-600 text-2xl"></i></div>
          </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="p-4 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-900"><i class="fas fa-desktop mr-2"></i>Riwayat Simulasi Rakitan PC</h2>
        </div>
        <div class="overflow-x-auto mt-4">
          <table id="simulationTable" class="w-full text-sm text-left text-gray-500 display nowrap" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th class="px-6 py-3">Kode</th>
                <th class="px-6 py-3">Processor</th>
                <th class="px-6 py-3">Motherboard</th>
                <th class="px-6 py-3">RAM</th>
                <th class="px-6 py-3">Casing</th>
                <th class="px-6 py-3">SSD</th>
                <th class="px-6 py-3">HDD</th>
                <th class="px-6 py-3">VGA</th>
                <th class="px-6 py-3">PSU</th>
                <th class="px-6 py-3">Mouse</th>
                <th class="px-6 py-3">Keyboard</th>
                <th class="px-6 py-3">Monitor</th>
                <th class="px-6 py-3">Cooler Fan</th>
                <th class="px-6 py-3">Total Harga</th>
                <th class="px-6 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($simulasiTerbaru as $rakit)
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $rakit->kode_rakitan }}</td>
                <td class="px-6 py-4">{{ $rakit->processor }}</td>
                <td class="px-6 py-4">{{ $rakit->motherboard }}</td>
                <td class="px-6 py-4">{{ $rakit->ram }}</td>
                <td class="px-6 py-4">{{ $rakit->casing }}</td>
                <td class="px-6 py-4">{{ $rakit->ssd }}</td>
                <td class="px-6 py-4">{{ $rakit->hdd }}</td>
                <td class="px-6 py-4">{{ $rakit->vga }}</td>
                <td class="px-6 py-4">{{ $rakit->psu }}</td>
                <td class="px-6 py-4">{{ $rakit->mouse }}</td>
                <td class="px-6 py-4">{{ $rakit->keyboard }}</td>
                <td class="px-6 py-4">{{ $rakit->monitor }}</td>
                <td class="px-6 py-4">{{ $rakit->coolerfan }}</td>
                <td class="px-6 py-4 font-bold">Rp {{ number_format($rakit->total_harga, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-center">
                    <button type="button" 
                        onclick="deleteSimulasi('{{ route('simulasi.destroy', $rakit->id) }}')" 
                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900"><i class="fas fa-users mr-2"></i>Karyawan</h2>
            
            @if(Auth::user()->role !== 'admin')
            <button type="button" data-modal-target="tambahModal" data-modal-toggle="tambahModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <i class="fas fa-plus mr-1"></i> Tambah Admin
            </button>
            @endif
        </div>

        <div class="overflow-x-auto mt-4">
          <table id="karyawanTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th class="px-6 py-3">Kode</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Jabatan</th>
                <th class="px-6 py-3">Detail</th>
                @if(Auth::user()->role !== 'admin') <th class="px-6 py-3 text-center">Aksi</th> @endif
              </tr>
            </thead>
            <tbody>
              @foreach($karyawanTerbaru as $user)
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $user->kode_admin }}</td>
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">{{ $user->jabatan }}</td>
                
                <td class="px-6 py-4">
                    <button onclick="showUserDetail(
                        '{{ $user->kode_admin }}', '{{ $user->name }}', '{{ $user->email }}', 
                        '{{ $user->jk }}', '{{ $user->jabatan }}', '{{ $user->role }}', 
                        '{{ $user->no_telfon }}', 
                        '{{ str_replace(["\r", "\n"], " ", addslashes($user->alamat)) }}', 
                        '{{ $user->foto ? asset('storage/' . $user->foto) : '' }}',
                        '{{ $user->cabang ? $user->cabang->nama : 'Semua Cabang' }}'
                    )" data-modal-target="viewModal" data-modal-toggle="viewModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Lihat data</button>
                </td>
                
                @if(Auth::user()->role !== 'admin')
                <td class="px-6 py-4 text-center flex justify-center gap-2">
                    
                    @if(Auth::id() == $user->id || $user->role == 'owner')
                        <button disabled class="bg-gray-300 text-white p-2 rounded cursor-not-allowed" title="Tidak bisa edit"><i class="fas fa-edit"></i></button>
                    @else
                        <button type="button" onclick="editKaryawan(
                            '{{ $user->id }}', '{{ $user->kode_admin }}', '{{ $user->name }}', '{{ $user->email }}', 
                            '{{ $user->jk }}', '{{ $user->jabatan }}', '{{ $user->role }}', 
                            '{{ $user->no_telfon }}', 
                            '{{ str_replace(["\r", "\n"], " ", addslashes($user->alamat)) }}', 
                            '{{ $user->id_cabang }}',
                            '{{ $user->foto ? asset('storage/' . $user->foto) : '' }}'
                        )" data-modal-target="editModal" data-modal-toggle="editModal" class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded"><i class="fas fa-edit"></i></button>
                    @endif

                    @if($user->role == 'owner' || Auth::id() == $user->id)
                        <button disabled class="bg-gray-300 text-white p-2 rounded cursor-not-allowed" title="Tidak bisa hapus"><i class="fas fa-trash"></i></button>
                    @else
                        <button type="button" onclick="deleteKaryawan('{{ route('karyawan.destroy', $user->id) }}')" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded"><i class="fas fa-trash"></i></button>
                    @endif

                </td>
                @endif
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
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Admin</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="tambahModal"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                </div>
                <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">ID Admin</label><input type="text" name="kode_admin" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="RK-101" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Nama</label><input type="text" name="name" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="Dave Elyada Gerika" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Password</label><input type="text" name="password" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="admin101" required></div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                            <select name="jk" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
                        </div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Email</label><input type="email" name="email" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="elyadadg@gmail.com" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Nomor Kontak</label><input type="text" name="no_telfon" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="087733332134"></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Jabatan</label><input type="text" name="jabatan" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="MANAGER" required></div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Cabang</label>
                            <select name="id_cabang" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Cabang</option>
                                @foreach($cabangs as $cab) <option value="{{ $cab->id }}">{{ $cab->nama }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select name="role" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                <option value="admin">Admin</option><option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Foto</label><input name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" type="file"></div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label><textarea name="alamat" rows="3" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"></textarea></div>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center"><i class="fas fa-plus mr-2"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div id="viewModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
          <div class="relative p-4 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
              <h3 class="text-lg font-semibold text-gray-900">Data Admin</h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="viewModal"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1"><div class="flex flex-col items-center"><div class="w-40 h-40 rounded-lg overflow-hidden bg-gray-100 shadow-md mb-4"><img id="modal-foto" src="" alt="Profile" class="w-full h-full object-cover"></div></div></div>
                <div class="lg:col-span-2">
                  <div class="space-y-6">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                      <h2 id="modal-kode" class="text-3xl font-bold text-gray-900"></h2>
                      <span id="modal-role" class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded uppercase"></span>
                    </div>
                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Nama</div><div class="col-span-2" id="modal-nama"></div></div>
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Email</div><div class="col-span-2" id="modal-email"></div></div>
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Gender</div><div class="col-span-2" id="modal-jk"></div></div>
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Jabatan</div><div class="col-span-2" id="modal-jabatan"></div></div>
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Cabang</div><div class="col-span-2" id="modal-cabang"></div></div>
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Telp</div><div class="col-span-2" id="modal-telp"></div></div>
                        <div class="grid grid-cols-3 gap-4"><div class="font-semibold text-gray-900">Alamat</div><div class="col-span-2" id="modal-alamat"></div></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div id="editModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Karyawan</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="editModal"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                </div>
                <form id="form-edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex justify-center mb-4"><div class="w-32 h-32 bg-gray-100 rounded-lg shadow overflow-hidden"><img id="edit-foto-preview" src="" class="w-full h-full object-contain"></div></div>
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">ID Admin</label><input type="text" id="edit-kode" name="kode_admin" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" readonly></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Nama</label><input type="text" id="edit-nama" name="name" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Password (Opsional)</label><input type="text" name="password" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="******"></div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                            <select id="edit-jk" name="jk" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
                        </div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Email</label><input type="email" id="edit-email" name="email" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Nomor Kontak</label><input type="text" id="edit-telp" name="no_telfon" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Jabatan</label><input type="text" id="edit-jabatan" name="jabatan" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"></div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Cabang</label>
                            <select id="edit-cabang" name="id_cabang" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Cabang</option>
                                @foreach($cabangs as $cab) <option value="{{ $cab->id }}">{{ $cab->nama }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select id="edit-status" name="role" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                <option value="admin">Admin</option><option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Foto</label><input name="foto" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" type="file"></div>
                        <div class="sm:col-span-2"><label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label><textarea id="edit-alamat" name="alamat" rows="3" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"></textarea></div>
                    </div>
                    <button type="submit" class="text-white bg-yellow-400 hover:bg-yellow-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center"><i class="fas fa-save mr-2"></i> Update</button>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="deleteModal"><svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
            <i class="fas fa-exclamation-triangle text-gray-400 text-5xl mb-3"></i>
            <p class="mb-4 text-gray-500">Apakah anda yakin menghapus karyawan ini?</p>
            <div class="flex justify-center items-center space-x-4">
              <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Urungkan</button>
              <form id="delete-form" method="POST" action="">@csrf @method('DELETE')<button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700">Ya, yakin</button></form>
            </div>
          </div>
        </div>
    </div>

    <div id="deleteSimulasiModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            
            <button type="button" onclick="deleteSimulasiInstance.hide()" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            
            <i class="fas fa-exclamation-triangle text-gray-400 text-5xl mb-3"></i>
            <p class="mb-4 text-gray-500">Yakin hapus riwayat simulasi ini?</p>
            
            <div class="flex justify-center items-center space-x-4">
              <button type="button" onclick="deleteSimulasiInstance.hide()" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Batal</button>
              
              <form id="delete-simulasi-form" method="POST" action="">
                  @csrf @method('DELETE')
                  <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700">Ya, Hapus</button>
              </form>
            </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let deleteSimulasiInstance = null;

    $(document).ready(function () {
        $('#simulationTable').DataTable({ responsive: true, scrollX: true });
        $('#karyawanTable').DataTable({ responsive: true, scrollX: true });

        // Init Manual Modal for Simulation Delete (because it's new)
        const delSimEl = document.getElementById('deleteSimulasiModal');
        if (window.Modal) {
            deleteSimulasiInstance = new window.Modal(delSimEl);
        }
    });

    // FUNGSI VIEW DETAIL
    function showUserDetail(kode, nama, email, jk, jabatan, role, telp, alamat, fotoUrl, cabang) {
        document.getElementById('modal-kode').innerText = kode;
        document.getElementById('modal-nama').innerText = nama;
        document.getElementById('modal-email').innerText = email;
        document.getElementById('modal-jk').innerText = (jk === 'L' ? 'Laki-laki' : 'Perempuan');
        document.getElementById('modal-jabatan').innerText = jabatan;
        document.getElementById('modal-cabang').innerText = cabang ? cabang : '-';
        document.getElementById('modal-role').innerText = role.toUpperCase();
        document.getElementById('modal-telp').innerText = telp || '-';
        document.getElementById('modal-alamat').innerText = alamat || '-';
        
        let imgEl = document.getElementById('modal-foto');
        if (fotoUrl) { imgEl.src = fotoUrl; } else { imgEl.src = "{{ asset('assets/images/RatuKom_hitam.png') }}"; }
    }

    // FUNGSI EDIT KARYAWAN
    function editKaryawan(id, kode, nama, email, jk, jabatan, role, telp, alamat, cabangId, fotoUrl) {
        document.getElementById('form-edit').action = '/karyawan/' + id;
        document.getElementById('edit-kode').value = kode;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-jk').value = jk;
        document.getElementById('edit-jabatan').value = jabatan;
        document.getElementById('edit-status').value = role;
        document.getElementById('edit-telp').value = telp ? telp : '';
        document.getElementById('edit-alamat').value = alamat ? alamat : '';
        
        let cabangSelect = document.getElementById('edit-cabang');
        if(cabangSelect) { cabangSelect.value = cabangId ? cabangId : ''; }

        let imgPreview = document.getElementById('edit-foto-preview');
        imgPreview.src = fotoUrl ? fotoUrl : "{{ asset('assets/images/RatuKom_hitam.png') }}";
        imgPreview.onerror = function() { this.src = "{{ asset('assets/images/RatuKom_hitam.png') }}"; };
    }

    function deleteKaryawan(url) {
        document.getElementById('delete-form').action = url;
    }

    // FUNGSI DELETE SIMULASI (MANUAL MODAL)
    function deleteSimulasi(url) {
        document.getElementById('delete-simulasi-form').action = url;
        if(deleteSimulasiInstance) deleteSimulasiInstance.show();
    }
</script>
@endpush