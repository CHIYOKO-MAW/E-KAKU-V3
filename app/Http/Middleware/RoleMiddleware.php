<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin') or multiple roles 'role:admin,atasan'
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $roleList = array_map('trim', explode(',', $roles));
        if (! in_array($request->user()->role, $roleList)) {
            // optional: redirect to dashboard with error
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}

