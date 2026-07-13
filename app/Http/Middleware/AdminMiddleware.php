<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Not logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Not admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Admins only.');
        }

        return $next($request);
    }
}