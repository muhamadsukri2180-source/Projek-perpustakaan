<?php

namespace App\Http\Middleware;

use Closure;
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
    if (!Auth::guard('web')->check()) {
        return redirect()->route('login.role', ['role' => 'admin'])
            ->with('error', 'Silakan login terlebih dahulu.');
    }

    /** @var \App\Models\User $user */
    $user = Auth::guard('web')->user();

    if ($user->role !== 'admin') {
        return redirect('/')->with('error', 'Kamu tidak memiliki akses ke halaman Admin!');
    }

    return $next($request);
}
}