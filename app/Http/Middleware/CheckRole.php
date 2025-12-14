<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = Auth::user()->role ? Auth::user()->role->name : null; // Access role name via relationship

        // If user's role is in the allowed roles list, proceed
        if ($userRole && in_array($userRole, $roles)) {
            return $next($request);
        }

        // If unauthorized, return 403
        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}
