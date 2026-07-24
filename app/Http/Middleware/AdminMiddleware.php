<?php

namespace App\Http\Middleware;

use Closure; // <-- Perbaikan di sini (sebelumnya hanya 'Closure;')
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role user adalah 'admin'
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'admin') {
            // Jika bukan admin, arahkan ke halaman utama
            return redirect('/')->with('error', 'Kamu tidak memiliki akses ke halaman Admin!');
        }

        return $next($request);
    }
}