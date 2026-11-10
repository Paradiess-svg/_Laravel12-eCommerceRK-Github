{{--
    Asset loader untuk halaman yang memakai layout Breeze.

    Di lokal/CI, hasil `npm run build` biasanya tersedia sehingga @vite dipakai.
    Di hosting yang belum punya public/build/manifest.json, @vite akan melempar
    error "Vite manifest not found". Fallback ke Tailwind CDN supaya halaman
    login/register/profil tetap bisa dibuka.
--}}
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.tailwindcss.com"></script>
@endif
