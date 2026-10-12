<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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
