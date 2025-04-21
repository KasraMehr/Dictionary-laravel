<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
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

  public function handleGoogleCallback()
  {
      $googleUser = Socialite::driver('google')->stateless()->user();

      $user = User::firstOrCreate(
          ['email' => $googleUser->getEmail()],
          [
              'name' => $googleUser->getName(),
              'password' => bcrypt(Str::random(16)), // رمز عبور تصادفی برای حساب گوگل
              'role' => 'student', // می‌توانید نقش پیش‌فرض را تعیین کنید
          ]
      );

      Auth::login($user);

      return redirect()->intended(match(auth()->user()->role) {
          'translator' => route('translator.dashboard'),
          'teacher' => route('teacher.dashboard'),
          'student' => route('student.dashboard'),
          default => '/landing'
      });
  }
}
