<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // اجازه دسترسی به مسیرهای ورود و خروج
        if ($request->is('admin/login') || $request->is('admin/logout')) {
            return $next($request);
        }

        if (!auth()->check()) {
            \Illuminate\Support\Facades\Log::warning('Unauthenticated access attempt to admin panel');
            return redirect()->route('filament.admin.auth.login');
        }

        if (auth()->user()->role !== 'admin') {
            \Illuminate\Support\Facades\Log::warning('User with role ' . auth()->user()->role . ' attempted to access admin panel');
            abort(403, __('auth.unauthorized'));
        }

        return $next($request);
    }
}
