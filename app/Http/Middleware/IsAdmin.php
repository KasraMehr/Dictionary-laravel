<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/login')) {
            return $next($request);
        }

        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, __('auth.unauthorized'));
        }

        return $next($request);
    }
}
