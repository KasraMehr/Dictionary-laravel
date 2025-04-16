<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * مسیر پیش‌فرض بعد از لاگین
     */
     public const HOME = '/redirect-after-login';

    /**
     * Bootstrap your route-related services.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    public static function homeRoute(): string
    {
        $user = auth()->user();
        return match ($user->role) {
            'student' => route('student.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'translator' => route('translator.dashboard'),
            default => self::HOME,
        };
    }
}
