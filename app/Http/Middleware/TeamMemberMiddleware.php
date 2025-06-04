<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamMemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        $team = $request->route('team');

        $team->loadMissing(['owner', 'users']);

        if (! $team) {
            abort(404, 'Team not found');
        }

        $user = $request->user();

        if (($team->owner && $team->owner->id === $user->id) || $team->users->contains($user->id)) {
            return $next($request);
        }

        abort(403, 'You are not a member of this team.');
    }
}
