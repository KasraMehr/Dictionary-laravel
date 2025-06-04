<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        return redirect()->intended($this->redirectPath());
    }

    protected function redirectPath()
    {
        return match (auth()->user()->role) {
            'translator' => route('translator.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'student' => route('student.dashboard'),
            default => '/dashboard',
        };
    }
}
