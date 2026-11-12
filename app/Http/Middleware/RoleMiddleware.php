<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/')
                ->with('error', 'Anda tidak punya akses ke halaman itu.');
        }

        return $next($request);
    }
}
