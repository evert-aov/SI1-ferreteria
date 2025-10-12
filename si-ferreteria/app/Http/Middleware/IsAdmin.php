<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $rolPrincipal = $user->getRolPrincipal();

        if (!$rolPrincipal || $rolPrincipal->level < 10)
            abort(403, 'Acceso denegado, no es administrador.');

        return $next($request);
    }
}
