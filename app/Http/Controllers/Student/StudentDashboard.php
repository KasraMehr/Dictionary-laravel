<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class StudentDashboard extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->studentProfile;
        $studentProgress = $user->studentProgress;

        return Inertia::render('Student/Dashboard', [
            'student' => $student,
            'studentProgress' => $studentProgress,
            'quickActions' => $this->getQuickActions(),
            'activeCourses' => $this->getActiveCourses($user),
            'savedWords' => $this->getSavedWords($user),
            'dailyChallenge' => $this->getDailyChallenge($user),
            'learningStats' => $this->getLearningStats($user),
            'userLevel' => $this->calculateUserLevel($user),
        ]);
    }

    protected function getQuickActions()
    {
        return [
            [
                'icon' => 'play',
                'title' => 'ادامه یادگیری',
                'subtitle' => 'دوره فعلی خود را ادامه دهید',
                'bgColor' => 'bg-indigo-500',
            ],
            [
                'icon' => 'plus-circle',
                'title' => 'کلمه جدید',
                'subtitle' => 'کلمه ای به دیکشنری اضافه کنید',
                'bgColor' => 'bg-green-500',
            ],
            [
                'icon' => 'microphone',
                'title' => 'تمرین تلفظ',
                'subtitle' => 'مهارت speaking خود را تقویت کنید',
                'bgColor' => 'bg-amber-500',
            ],
            [
                'icon' => 'book-open',
                'title' => 'فلش کارت',
                'subtitle' => 'کلمات را مرور کنید',
                'bgColor' => 'bg-purple-500',
            ],
        ];
    }

    protected function getActiveCourses($user)
    {
        return $user->courses()
            ->whereNull('course_user.completed_at') // تغییر این خط
            ->with('teacher')
            ->orderByDesc('course_user.updated_at')
            ->limit(3)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'teacher' => $course->teacher->name,
                    'image' => $course->image_url,
                    'progress' => $course->pivot->progress,
                    'rating' => $course->average_rating,
                ];
            });
    }

    protected function getSavedWords($user)
    {
        return $user->savedWords()
            ->orderByDesc('saved_words.created_at')
            ->limit(5)
            ->get()
            ->map(function ($word) {
                return [
                    'id' => $word->id,
                    'word' => $word->text,
                    'meaning' => $word->translation,
                    'level' => $word->level,
                ];
            });
    }

    protected function getDailyChallenge($user)
    {
        // در اینجا می‌توانید منطق دریافت چالش روزانه را پیاده‌سازی کنید
        return [
            'title' => '10 کلمه جدید امروز',
            'description' => 'این 10 کلمه را یاد بگیرید و 50 امتیاز کسب کنید!',
            'timeLeft' => '15 دقیقه باقی مانده',
            'wordsCount' => 10,
            'points' => 50,
        ];
    }

    protected function getLearningStats($user)
    {
        $stats = $user->learningStat;

        return [
            'learnedWords' => $stats->learned_words_count ?? 0,
            'activeDays' => $stats->active_days_streak ?? 0,
            'studyTime' => $this->formatStudyTime($stats->total_study_minutes ?? 0),
            'rank' => $stats->rank ?? 0,
            'totalUsers' => 5000,
        ];
    }

    protected function calculateUserLevel($user)
    {
        $progress = $user->studentProgress->first();

        if (! $progress) {
            return 'A1';
        }

        $points = $progress->level;

        if ($points >= 5) {
            return 'C2';
        }
        if ($points >= 4) {
            return 'C1';
        }
        if ($points >= 3) {
            return 'B2';
        }
        if ($points >= 2) {
            return 'B1';
        }
        if ($points >= 1) {
            return 'A2';
        }

        return 'A1';
    }

    protected function formatStudyTime($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return "{$hours}h {$remainingMinutes}m";
    }

    public function profile(): Response
    {
        $user = Auth::user();
        $profile = $user->studentProfile;
        $studentProgress = $user->studentProgress;

        return inertia('Student/Profile', [
            'user' => $user,
            'studentProfile' => $profile,
            'studentProgress' => $studentProgress,
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
            'theme' => 'nullable|in:light,dark',
        ]);

        // بروزرسانی اطلاعات کاربر
        $user->update([
            'name' => $request->name,
            'theme' => $request->theme ?? $user->theme,
        ]);

        // بروزرسانی یا ایجاد پروفایل
        $user->studentProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'bio', 'phone', 'country', 'learning_languages',
                'known_languages', 'education_level', 'occupation',
                'learning_goals', 'preferred_learning_style', 'daily_study_time',
            ])
        );

        return redirect()->back()->with('success', 'پروفایل با موفقیت بروزرسانی شد');
    }
}
