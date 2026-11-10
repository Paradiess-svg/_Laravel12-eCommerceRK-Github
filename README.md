<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Catatan: Ratu komputer telah di deploy dan menjadi https://ratubaguskomputer.id/ dan jika di sisi admin terlalu lama tak beroprasi, sesionnya akan habis, namun dia tidak redirect ke halaman login, malah menyebutkan pesan error seperti 403 atau 500.

## Catatan Lokal (Laragon)

- Nyalakan **MySQL** dari Laragon, lalu sesuaikan `.env`:
  `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=laravel12_e_commerce_rk`,
  `DB_USERNAME=root`, `DB_PASSWORD=` (kosong).
- Document root web server harus diarahkan ke folder `public`, bukan folder
  root project. Alternatif paling gampang: jalankan `php artisan serve`.
- Setelah mengubah `.env`, jalankan `php artisan config:clear`.
- Error `PDO::MYSQL_ATTR_SSL_CA is deprecated` di PHP 8.5 sudah ditangani di
  `bootstrap/app.php` (hanya pesan deprecation tersebut yang diabaikan).

## Catatan Deploy (Exabytes / cPanel)

- Jalankan `composer install --no-dev --optimize-autoloader`, lalu `php artisan migrate --force`.
- Pastikan `.env` berisi `APP_URL` yang benar dan kredensial database hosting.
- Upload gambar otomatis memilih disk:
  - lokal: `public/storage` (tanpa perlu symlink),
  - hosting: `../public_html/storage` (webroot Exabytes).
  Jika struktur folder hosting berbeda, set `UPLOAD_DISK` dan/atau
  `PUBLIC_HTML_STORAGE_PATH` di `.env`, lalu `php artisan config:clear`.
- Folder tujuan upload harus writable oleh user PHP (biasanya permission `755`
  atau `775`).
- Halaman login/forgot-password tetap tampil walau `public/build` belum ada,
  karena ada fallback Tailwind CDN. Untuk tampilan produksi yang optimal tetap
  jalankan `npm install && npm run build` bila Node.js tersedia.
- Pendaftaran publik (`/register`) sengaja dimatikan. Akun admin dibuat oleh
  owner/super admin melalui menu **Dashboard > Karyawan**.
- Sesi yang habis sekarang diarahkan kembali ke halaman login dengan pesan yang
  jelas, bukan halaman 403/500.
