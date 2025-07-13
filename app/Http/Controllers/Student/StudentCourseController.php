<?php

// app/Http/Controllers/Student/CourseController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class StudentCourseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $userId = $user->id;

        $courses = Course::query()
            ->leftJoin('course_user', function ($join) use ($userId) {
                $join->on('courses.id', '=', 'course_user.course_id')
                    ->where('course_user.user_id', '=', $userId);
            })
            ->leftJoin('users as creators', 'creators.id', '=', 'courses.created_by')
            ->where('courses.status', 'published')
            ->whereHas('course_lessons')
            ->select([
                'courses.*',
                'creators.name as creator_name',
                'course_user.enrolled_at as pivot_enrolled_at',
                'course_user.updated_at as pivot_updated_at',
                'course_user.is_favorite as pivot_is_favorite',
            ])
            ->with(['course_lessons' => function($query) use ($userId) {
                $query->with(['users' => function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }]);
            }])
            ->withCount('course_lessons')
            ->orderBy('courses.created_at', 'desc')
            ->paginate(12);

// محاسبه پراگرس برای هر دوره
        $courses->getCollection()->transform(function ($course) {
            $totalLessons = $course->course_lessons->count();
            $completedLessons = $course->course_lessons->filter(function ($lesson) {
                return $lesson->users->isNotEmpty() && $lesson->users->first()->pivot->completed;
            })->count();

            $course->pivot_progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
            $course->pivot_enrolled_at = $course->pivot_enrolled_at ?? null;
            $course->pivot_is_favorite = $course->pivot_is_favorite ?? false;
            $course->pivot = (object) [
                'progress' => $course->pivot_progress,
                'enrolled_at' => $course->pivot_enrolled_at,
                'is_favorite' => $course->pivot_is_favorite,
            ];
            return $course;
        });

        $userCourses = $user->courses()->with(['course_lessons' => function($query) use ($userId) {
            $query->with(['users' => function($query) use ($userId) {
                $query->where('user_id', $userId);
            }]);
        }])->get();

        $stats = [
            'total_courses' => $userCourses->count(),
            'in_progress' => $userCourses->filter(function ($course) {
                $totalLessons = $course->course_lessons->count();
                $completedLessons = $course->course_lessons->filter(function ($lesson) {
                    return $lesson->users->isNotEmpty() && $lesson->users->first()->pivot->completed;
                })->count();
                $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                return $progress > 0 && $progress < 100;
            })->count(),
            'completed' => $userCourses->filter(function ($course) {
                $totalLessons = $course->course_lessons->count();
                $completedLessons = $course->course_lessons->filter(function ($lesson) {
                    return $lesson->users->isNotEmpty() && $lesson->users->first()->pivot->completed;
                })->count();
                $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                return $progress === 100;
            })->count(),
        ];

        return inertia('Student/Courses/Index', [
            'courses' => $courses,
            'stats' => $stats,
        ]);
    }

    public function show(Course $course)
    {
        $user = auth()->user();

        $course->load(['course_lessons' => function($query) use ($user) {
            $query->with(['users' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        }]);

        // محاسبه پیشرفت
        $totalLessons = $course->course_lessons->count();
        $completedLessons = $course->course_lessons->filter(function ($lesson) {
            return $lesson->users->isNotEmpty() && $lesson->users->first()->pivot->completed;
        })->count();

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        // اضافه کردن وضعیت تکمیل برای هر درس
        $lessons = $course->course_lessons->map(function ($lesson) use ($user) {
            $lesson->is_completed = $lesson->users->isNotEmpty()
                ? $lesson->users->first()->pivot->completed
                : false;
            return $lesson;
        });

        return inertia('Student/Courses/Show', [
            'course' => $course,
            'lessons' => $lessons,
            'progress' => $progress,
        ]);
    }

    public function markAsCompleted(Request $request, CourseLesson $lesson)
    {
        try {
            $user = $request->user();
            $now = now();

            // بررسی وجود درس و دوره
            if (!$lesson->course) {
                return inertia('Student/Courses/Show', [
                    'error' => 'درس به دوره‌ای متصل نیست',
                ])->with(['error' => 'درس به دوره‌ای متصل نیست']);
            }

            // ثبت تکمیل درس
            $user->lessons()->syncWithoutDetaching([
                $lesson->id => [
                    'completed' => true,
                    'completed_at' => $now,
                    'progress' => 100,
                    'started_at' => $now,
                ]
            ]);

            // بارگذاری دوره و درس‌ها مشابه متد show
            $course = $lesson->course;
            $course->load(['course_lessons' => function ($query) use ($user) {
                $query->with(['users' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }]);
            }]);

            // محاسبه پیشرفت دوره
            $totalLessons = $course->course_lessons->count();
            $completedLessons = $course->course_lessons->filter(function ($lesson) {
                return $lesson->users->isNotEmpty() && $lesson->users->first()->pivot->completed;
            })->count();
            $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

            // به‌روزرسانی پیشرفت دوره در pivot
            $user->courses()->updateExistingPivot($course->id, [
                'progress' => $courseProgress,
                'last_accessed_at' => $now,
                'completed_at' => $courseProgress >= 100 ? $now : null,
            ]);

            // اضافه کردن وضعیت تکمیل برای هر درس
            $lessons = $course->course_lessons->map(function ($lesson) use ($user) {
                $lesson->is_completed = $lesson->users->isNotEmpty()
                    ? $lesson->users->first()->pivot->completed
                    : false;
                return $lesson;
            });

            // به‌روزرسانی آمار یادگیری
            $learningStat = $user->learningStat()->firstOrCreate(['user_id' => $user->id]);
            $lastStudiedAt = $learningStat->last_studied_at ? Carbon::parse($learningStat->last_studied_at) : null;
            $streak = $learningStat->active_days_streak ?? 0;

            if (!$lastStudiedAt || $lastStudiedAt->isBefore($now->startOfDay())) {
                if ($lastStudiedAt && $lastStudiedAt->isYesterday()) {
                    $streak++;
                } else {
                    $streak = 1;
                }
            }

            $dailyProgress = $learningStat->daily_goals ?? [];
            $today = $now->format('Y-m-d');
            $dailyProgress[$today] = ($dailyProgress[$today] ?? 0) + 1;

            $weeklyProgress = $learningStat->weekly_progress ?? [];
            $weekStart = $now->startOfWeek()->format('Y-m-d');
            $weeklyProgress[$weekStart] = ($weeklyProgress[$weekStart] ?? 0) + 1;

            $learningStat->update([
                'active_days_streak' => $streak,
                'last_studied_at' => $now,
                'daily_goals' => $dailyProgress,
                'weekly_progress' => $weeklyProgress,
                'total_study_minutes' => ($learningStat->total_study_minutes ?? 0) + 10,
            ]);

            // افزایش XP در StudentProgress
            $studentProgress = $user->studentProgress()->firstOrCreate(['user_id' => $user->id]);
            $xpGained = 10;
            $newLevel = $this->calculateLevel(($studentProgress->xp ?? 0) + $xpGained);

            $studentProgress->update([
                'xp' => ($studentProgress->xp ?? 0) + $xpGained,
                'level' => $newLevel,
                'lessons_completed' => ($studentProgress->lessons_completed ?? 0) + 1,
            ]);

            // پاسخ به درخواست Inertia
            if ($request->header('X-Inertia')) {
                return inertia('Student/Courses/Show', [
                    'course' => $course,
                    'lessons' => $lessons,
                    'progress' => $courseProgress,
                    'dailyProgress' => $dailyProgress[$today],
                    'weeklyProgress' => $weeklyProgress[$weekStart],
                    'streak' => $streak,
                    'xp' => $studentProgress->xp,
                    'level' => $newLevel,
                    'flash' => ['success' => 'درس با موفقیت به عنوان تکمیل شده علامت گذاری شد'],
                ]);
            }

            // پاسخ به درخواست API
            return response()->json([
                'success' => true,
                'message' => 'درس با موفقیت به عنوان تکمیل شده علامت گذاری شد',
                'course' => $course,
                'lessons' => $lessons,
                'course_progress' => $courseProgress,
                'daily_progress' => $dailyProgress[$today],
                'weekly_progress' => $weeklyProgress[$weekStart],
                'streak' => $streak,
                'xp' => $studentProgress->xp,
                'level' => $newLevel,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in markAsCompleted: ' . $e->getMessage());
            if ($request->header('X-Inertia')) {
                return inertia('Student/Courses/Show', [
                    'course' => $lesson->course,
                    'lessons' => $lesson->course->course_lessons,
                    'progress' => 0,
                    'flash' => ['error' => env('APP_DEBUG') ? $e->getMessage() : 'خطایی در سرور رخ داد'],
                ]);
            }
            return response()->json([
                'success' => false,
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'خطایی در سرور رخ داد',
            ], 500);
        }
    }
    private function calculateLevel($xp)
    {
        return floor($xp / 100) + 1;
    }

    public function destroy(Course $course)
    {
        auth()->user()->courses()->detach($course);

        return redirect()->route('student.courses.index')
            ->with('success', 'از دوره انصراف دادید.');
    }
}
