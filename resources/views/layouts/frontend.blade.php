<!doctype html>
<html class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ratu Komputer')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        header.sticky-top { position: sticky; top: 0; z-index: 50; }
        header.navbar-hidden { transform: translateY(-100%); }
        header.navbar-visible { transform: translateY(0); }
        header { transition: transform 0.3s ease-in-out; }
        
        .judul-potong { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .deskripsi-potong { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        /* FIX 7: STYLING TOMBOL SILANG (X) DI SEARCH BAR */
        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            margin-right: 10px; /* Geser agak kiri dikit biar gak mepet */
            background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' fill='%23ef4444'><path d='M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65.1 65.6 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z'/></svg>") no-repeat center center;
            cursor: pointer;
        }
    </style>
</head>

<body class="font-[Roboto] bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <header id="main-header" class="bg-slate-700 shadow-lg fixed top-0 w-full z-50 transition-all duration-300">
        <div class="w-[92%] mx-auto py-3 flex flex-wrap items-center justify-between gap-4">
            
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                <img class="w-20 md:w-32" src="{{ asset('assets/images/logoratu 4.png') }}" alt="Logo">
            </a>

            <button id="menu-toggle" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-gray-200 ml-auto md:ml-0 order-2 md:order-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>

            <div class="hidden w-full md:flex md:w-auto md:flex-grow md:items-center md:justify-end gap-6 order-3 md:order-1" id="navbar-sticky">
                
                <div class="w-full md:max-w-xl mx-auto mt-4 md:mt-0 flex-grow">
                    <form class="w-full" action="{{ route('katalog') }}" method="GET">
                        <div class="relative w-full">
                            <input class="rounded-lg w-full text-black px-4 py-2 pr-12 border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                type="search" name="q" placeholder="Cari produk, kategori, atau cabang..." value="{{ request('q') }}">
                            <button type="submit" class="absolute top-0 right-0 h-full px-4 text-gray-500 flex items-center justify-center hover:text-slate-700 rounded-r-lg bg-gray-100 border-l border-gray-300">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex-shrink-0 text-xl md:text-2xl mt-6 md:mt-0 text-center">
                    <a href="{{ url('/simulasi') }}" class="inline-block animate-bounce font-bold text-white hover:text-blue-200 transition whitespace-nowrap">
                        <i class="fa-solid fa-computer"></i> Rakit PC!
                    </a>
                </div>
                
                <div class="md:hidden mt-4 border-t border-slate-600 pt-4 text-white">
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('katalog') }}" class="block hover:text-gray-300">Katalog</a></li>
                        <li><a href="{{ route('home') }}#popular" class="block hover:text-gray-300">Popular</a></li>
                        <li><a href="{{ route('home') }}#rakitpc" class="block hover:text-gray-300">Rakit PC</a></li>
                        <li><a href="{{ route('home') }}#konsultasi" class="block hover:text-gray-300">Konsultasi</a></li>
                        <li><a href="{{ route('home') }}#kontak" class="block hover:text-gray-300">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </div>

        @if(request()->routeIs('home'))
        <div class="hidden md:block bg-slate-100 border-b border-gray-200">
            <div class="w-[90%] mx-auto">
                <ul class="flex flex-row justify-around p-3">
                    <li class="hover:scale-105 transition duration-200"><a href="{{ route('katalog') }}" class="flex flex-row items-center gap-x-2 text-slate-700 font-medium"><img class="w-6" src="{{ asset('assets/images/Katalog.png') }}"> Katalog</a></li>
                    <li class="hover:scale-105 transition duration-200"><a href="#popular" class="flex flex-row items-center gap-x-2 text-slate-700 font-medium"><img class="w-6" src="{{ asset('assets/images/Popular.png') }}"> Popular</a></li>
                    <li class="hover:scale-105 transition duration-200"><a href="#rakitpc" class="flex flex-row items-center gap-x-2 text-slate-700 font-medium"><img class="w-6" src="{{ asset('assets/images/RakitPC.png') }}"> Rakit PC</a></li>
                    <li class="hover:scale-105 transition duration-200"><a href="#konsultasi" class="flex flex-row items-center gap-x-2 text-slate-700 font-medium"><img class="w-6" src="{{ asset('assets/images/Konsultasi.png') }}"> Konsultasi</a></li>
                    <li class="hover:scale-105 transition duration-200"><a href="#kontak" class="flex flex-row items-center gap-x-2 text-slate-700 font-medium"><img class="w-6" src="{{ asset('assets/images/Kontak.png') }}"> Kontak</a></li>
                </ul>
            </div>
        </div>
        @endif
    </header>

    <div class="h-[80px]"></div>

    <main class="flex-grow">
        
        @yield('content')

    </main>

    <footer class="bg-slate-700 mt-auto">
        <div class="mx-auto w-full max-w-7xl p-4 py-6 lg:py-10">
            <div class="md:flex md:justify-between md:gap-8">
                <div class="mb-8 md:mb-0 max-w-xs text-center md:text-left mx-auto md:mx-0">
                    <a href="#" class="flex items-center justify-center md:justify-start mb-4">
                        <img src="{{ asset('assets/images/logoratu 4.png') }}" class="h-12 me-3" alt="Logo" />
                    </a>
                    <p class="text-sm text-gray-300">Toko komputer terpercaya dengan produk berkualitas dan pelayanan terbaik untuk kebutuhan teknologi Anda.</p>
                </div>
                <div class="grid gap-8 sm:gap-12 w-full md:w-auto justify-center text-center md:text-right md:justify-end">
                    <div>
                        <h2 class="mb-6 text-base font-bold uppercase text-white">Jam Operasional</h2>
                        <ul class="text-gray-300 space-y-1 text-sm">
                            <li>Senin - Sabtu: 09:00 - 21:00</li>
                            <li>Minggu: 10:00 - 18:00</li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-base font-bold uppercase text-white">Media Sosial & Kontak</h2>
                        <ul class="text-gray-300 space-y-1 text-sm hover:text-gray-100 transition">
                            <li><a href="https://instagram.com/ratu.computer" target="_blank"><i class="fa-brands fa-instagram"></i> ratu.computer</a></li>
                            <li><a href="https://wa.me/6287773599434" target="_blank"><i class="fa-brands fa-whatsapp"></i> 0877-7359-9434</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-8 border-gray-600 sm:mx-auto" />
            <div class="sm:flex sm:items-center sm:justify-center">
                <span class="text-sm text-gray-300 text-center block">©2025 Ratu Komputer. Semua hak cipta dilindungi undang-undang.</span>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#menu-toggle').click(function () {
                $('#navbar-sticky').toggleClass('hidden');
            });
            
            // Logic Navbar Auto-Hide (FIX 8)
            let lastScrollTop = 0;
            const navbar = document.getElementById('main-header');
            const delta = 5;
            const navbarHeight = navbar.offsetHeight;

            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (Math.abs(lastScrollTop - scrollTop) <= delta) return;
                if (scrollTop > lastScrollTop && scrollTop > navbarHeight){
                    navbar.classList.remove('navbar-visible');
                    navbar.classList.add('navbar-hidden');
                } else {
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                }
                lastScrollTop = scrollTop;
            });
        });
    </script>
    @stack('scripts')
</body>
</html>