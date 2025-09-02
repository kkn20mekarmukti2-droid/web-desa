<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('formlogin')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        $userRole = $user->role;

        // Check if user has any of the required roles
        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Akses ditolak. Anda tidak memiliki permission untuk mengakses resource ini.'
                ], 403);
            }
            
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki permission untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
