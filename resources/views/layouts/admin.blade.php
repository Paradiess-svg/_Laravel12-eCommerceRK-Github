<!doctype html>
<html lang="id">
<head>
  <title>Ratu Komputer - Admin</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="//cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" }
          }
        }
      }
    }
  </script>
  
  <style>
    /* Styling Tambahan untuk DataTables biar rapi di Light Mode */
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
        color: #374151 !important;
        margin-bottom: 10px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #3b82f6 !important;
        color: white !important;
        border: 1px solid #3b82f6 !important;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-900">
  
  <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button id="sidebar-toggle" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Toggle sidebar</span>
            <i class="fa-solid fa-bars text-xl"></i>
          </button>
          <a href="#" class="flex ml-2 md:mr-24">
            <img src="{{ asset('assets/images/RatuKom_hitam.png') }}" class="h-8 mr-3" alt="Logo">
          </a>
        </div>
 <div class="flex items-center">
            


          <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm pe-1 font-medium text-gray-900 rounded-full hover:text-blue-600 md:me-0 focus:ring-4 focus:ring-gray-100" type="button">
            <span class="sr-only">Open user menu</span>
            <div class="relative w-8 h-8 overflow-hidden bg-gray-100 rounded-full mr-2 border border-gray-200">
                <img class="w-full h-full object-cover" 
                     src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('assets/images/RatuKom_hitam.png') }}" 
                     alt="user photo"
                     onerror="this.src='{{ asset('assets/images/RatuKom_hitam.png') }}';"> 
            </div>
            {{ Auth::user()->name }}
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
            <div class="px-4 py-3 text-sm text-gray-900">
              <div class="font-medium">{{ Auth::user()->role }}</div>
              <div class="truncate">{{ Auth::user()->email }}</div>
            </div>
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
              <li>
                <a href="{{ route('profil') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="fas fa-user-shield w-5 h-5 mr-2"></i> Profil
                </a>
              </li>
            </ul>
            <div class="py-2">
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-600 hover:text-white">
                      <i class="fa-solid fa-arrow-right-from-bracket w-5 h-5 mr-2"></i> Keluar
                  </a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-slate-700 border-r border-gray-700 md:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
        
        <li class="mb-4">
          <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">GENERAL</span>
        </li>
        
        <li>
          <a href="{{ route('dashboard') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fas fa-th-large w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Dasbor</span>
          </a>
        </li>
        
        <li class="mb-4 mt-6">
          <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">MENU</span>
        </li>

        <li>
          <a href="{{ route('produk.index') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('produk.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fa-solid fa-computer w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Produk</span>
          </a>
        </li>

        <li>
          <a href="{{ route('cabang.index') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('cabang.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fa-solid fa-store w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Cabang</span>
          </a>
        </li>

        <li>
          <a href="{{ route('hero.index') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('hero.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fas fa-newspaper w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Hero</span>
          </a>
        </li>

        <li>
          <a href="{{ route('gallery.index') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('gallery.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fa-solid fa-image w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Gallery</span>
          </a>
        </li>

        <li>
          <a href="{{ route('kategori.index') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('kategori.*') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fa-solid fa-list w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Kategori</span>
          </a>
        </li>
        
        <li class="mb-4 mt-6">
          <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">ADMIN</span>
        </li>

        <li>
          <a href="{{ route('profil') }}" 
             class="flex items-center p-2 rounded-lg group transition-colors duration-200
             {{ request()->routeIs('profil') ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <i class="fas fa-user-shield w-5 h-5 transition duration-75"></i>
            <span class="ml-3">Profil</span>
          </a>
        </li>

      </ul>
    </div>
  </aside>

  <div class="p-4 md:ml-64">
    <div class="p-4 mt-14">
        @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script>
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if(sidebarToggle){
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
        });
    }
  </script>
  @stack('scripts')
</body>
</html>