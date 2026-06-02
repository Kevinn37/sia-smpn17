<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah pengguna sudah login
        if (!session()->has('id_user')) {
            return redirect()->route('login');
        }

        // Cek apakah role pengguna sesuai
        $roleLogin = session('role');

        if (!in_array($roleLogin, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
