<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentProfile;

class StudentDashboard extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Student/Dashboard');
    }

    public function profile(): Response
    {
      $user = Auth::user();
      $profile = $user->studentProfile;
      $progress = $user->progress;

      return inertia('Student/Profile', [
          'user' => $user,
          'studentProfile' => $profile,
      ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'learning_languages' => 'nullable|array',
            'known_languages' => 'nullable|array',
            'education_level' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'learning_goals' => 'nullable|string',
            'preferred_learning_style' => 'nullable|string|max:100',
            'daily_study_time' => 'nullable|integer|min:0',
            'theme' => 'nullable|in:light,dark'
        ]);

        // بروزرسانی اطلاعات کاربر
        $user->update([
            'name' => $request->name,
            'theme' => $request->theme ?? $user->theme
        ]);

        // بروزرسانی یا ایجاد پروفایل
        $user->studentProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'bio', 'phone', 'country', 'learning_languages',
                'known_languages', 'education_level', 'occupation',
                'learning_goals', 'preferred_learning_style', 'daily_study_time'
            ])
        );

        return redirect()->back()->with('success', 'پروفایل با موفقیت بروزرسانی شد');
    }
}
