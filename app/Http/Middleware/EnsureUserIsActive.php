<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->is_active) {
            return $next($request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            abort(403, 'Akun Anda sedang nonaktif.');
        }

        return redirect()
            ->route('login')
            ->withErrors(['email' => 'Akun Anda sedang nonaktif. Hubungi admin PMB untuk mengaktifkan kembali akses.']);
    }
}
