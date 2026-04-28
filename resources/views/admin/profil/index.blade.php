@extends('layouts.admin')

@section('content')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">Admin</a>
          </li>
          <li>
            <div class="flex items-center">
              <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
              <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Profil Saya</span>
            </div>
          </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Profil Saya</h1>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Data Admin</h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded uppercase">
                {{ $user->role }}
            </span>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <div class="lg:col-span-1 flex flex-col items-center">
                    <div class="w-64 h-64 rounded-xl overflow-hidden shadow-md border-4 border-white mb-4">
                        @if($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" class="w-full h-full object-cover" alt="Foto Profil">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=0D8ABC&color=fff&size=256" class="w-full h-full object-cover" alt="Default">
                        @endif
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Foto Profil Saat Ini</p>
                </div>

                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-6 border-b pb-4 border-gray-100">
                        <h1 class="text-4xl font-extrabold text-gray-900">{{ $user->kode_admin }}</h1>
                    </div>

                    <div class="space-y-5 text-base text-gray-700">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Nama</div>
                            <div class="md:col-span-2 font-medium">{{ $user->name }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Email</div>
                            <div class="md:col-span-2 font-medium">{{ $user->email }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Gender</div>
                            <div class="md:col-span-2 font-medium">{{ $user->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Password</div>
                            <div class="md:col-span-2 font-medium text-gray-400 tracking-widest">
                                <span class="text-xs text-red-500 ml-2">Terenkripsi, jika lupa silahkan ganti password</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Jabatan</div>
                            <div class="md:col-span-2 font-medium uppercase">{{ $user->jabatan }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Cabang</div>
                            <div class="md:col-span-2 font-medium">
                                {{ $user->cabang ? $user->cabang->nama : 'Semua Cabang' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Telp</div>
                            <div class="md:col-span-2 font-medium">{{ $user->no_telfon ?? '-' }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="font-bold text-gray-900">Alamat</div>
                            <div class="md:col-span-2 font-medium leading-relaxed">
                                {{ $user->alamat ?? '-' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection