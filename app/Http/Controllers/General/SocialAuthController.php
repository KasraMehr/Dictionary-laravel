<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $role = $request->input('role', 'student');

        // ایجاد یا به‌روزرسانی کاربر
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)),
                'role' => $role,
                'profile_photo_path' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]
        );

        // ایجاد پروفایل بر اساس نقش
        if ($role === 'teacher') {
            $this->createTeacherProfile($user);
        } else {
            $this->createStudentProfile($user);
        }

        Auth::login($user);

        return redirect()->intended(
            $role === 'teacher' ? route('teacher.dashboard') : route('student.dashboard')
        );
    }

    private function createTeacherProfile(User $user)
    {
        Teacher::updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => 'استاد جدید',
                'bio' => null,
                'profile_photo_path' => $user->profile_photo_path,
            ]
        );
    }

    private function createStudentProfile(User $user)
    {
        StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
        );
    }
}
