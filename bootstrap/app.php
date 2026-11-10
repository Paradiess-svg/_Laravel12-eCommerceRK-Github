<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Kompatibilitas PHP 8.5
|--------------------------------------------------------------------------
|
| Laravel 12 masih memakai PDO::MYSQL_ATTR_SSL_CA di file config bawaan
| framework. Di PHP 8.5 konstanta itu memunculkan pesan deprecated setiap
| request/CLI. Pesan itu tidak menghentikan aplikasi, tapi mengotori output
| dan bisa merusak response header. Kita abaikan khusus pesan tersebut;
| deprecation lain tetap ditampilkan seperti biasa.
|
| Silakan hapus blok ini setelah framework memakai Pdo\Mysql::ATTR_SSL_CA.
|
*/
set_error_handler(static function (int $errno, string $errstr): bool {
    return $errno === E_DEPRECATED
        && str_contains($errstr, 'PDO::MYSQL_ATTR_SSL_CA');
});

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Token CSRF basi (biasanya karena sesi habis): jangan tampilkan "419 Page Expired"
        // (Laravel sudah mengubahnya jadi HttpException 419 sebelum sampai ke sini)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() !== 419 || $request->expectsJson()) {
                return null;
            }

            if (! \Illuminate\Support\Facades\Auth::check()) {
                return redirect()->guest(route('login'))
                    ->withErrors(['session' => 'Sesi kamu sudah habis. Silakan login kembali.']);
            }

            return redirect()->back()
                ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                ->withErrors(['session' => 'Halaman sudah kedaluwarsa. Silakan coba kirim ulang.']);
        });
    })->create();
