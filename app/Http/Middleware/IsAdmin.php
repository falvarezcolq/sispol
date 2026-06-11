<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->is_admin) {
            return redirect()->route('dashboard.index')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        return $next($request);
    }
}
