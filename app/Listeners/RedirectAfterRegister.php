<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class RedirectAfterRegister
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): RedirectResponse
    {
        $user = $event->user;

        // تغییر مسیر بر اساس role
        return redirect()->to(match ($user->role) {
            'student' => route('student.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'translator' => route('translator.dashboard'),
            default => '/landing',
        });
    }
}
