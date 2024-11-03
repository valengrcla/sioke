<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah terautentikasi
        if (!session('user')) {
            // Jika tidak, alihkan ke halaman login
            return redirect()->route('login'); // Sesuaikan dengan nama route login Anda
        }

        // Jika sudah terautentikasi, lanjutkan ke request berikutnya
        return $next($request);
    }
}
