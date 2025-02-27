<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Team;
use App\Models\User;

class TeamMemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
     {
       // استفاده مستقیم از مدل تزریق‌شده توسط Route Model Binding
       $team = $request->route('team');

       // اگر روابط از قبل بارگذاری نشده‌اند، آن‌ها را بارگذاری کن
       $team->loadMissing(['owner', 'users']);

       // بررسی اینکه آیا تیم پیدا شده است یا خیر
       if (!$team) {
          abort(404, 'Team not found');
        }

        // دریافت کاربر لاگین‌شده
        $user = $request->user();

        // بررسی مالکیت یا عضویت در تیم
        if (($team->owner && $team->owner->id === $user->id) || $team->users->contains($user->id)) {
          return $next($request);
        }

        abort(403, 'You are not a member of this team.');
      }

}
