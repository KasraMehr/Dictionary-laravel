<?php

// app/Http/Controllers/Student/CourseController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Models\User;
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
                'course_user.last_accessed_at as pivot_last_accessed_at',
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
            $course->pivot_last_accessed_at = $course->pivot_last_accessed_at ?? null;
            $course->pivot = (object) [
                'progress' => $course->pivot_progress,
                'enrolled_at' => $course->pivot_enrolled_at,
                'is_favorite' => $course->pivot_is_favorite,
                'last_accessed_at'=> $course->pivot_last_accessed_at,
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


        if($user->studentProfile->is_child){
          return inertia('Kid_Student/Courses/Index' , [
            'courses' => $courses,
            'stats' => $stats,
          ]);
        }
        else {
          return inertia('Student/Courses/Index', [
            'courses' => $courses,
            'stats' => $stats,
          ]);
        }
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



        $teacher = $course->teacher;

        // بررسی آیا دانش‌آموز از قبل به این استاد وصل است یا نه
        $user->teachers()->syncWithoutDetaching([
            $teacher->id => [
                'level' => $this->determineStudentLevel($user),
                'notes' => 'اتصال خودکار پس از تکمیل دوره: ' . $course->title,
                'status' => $this->determineCourseStatus($course, $user),
                'start_date' => now(),
                'end_date' => $this->determineEndDate($course, $user),
                'total_sessions' => $course->course_lessons()
                    ->whereHas('users', function($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->where('completed', true);
                    })
                    ->count()            ]
        ]);

        if($user->studentProfile->is_child){
          return inertia('Kid_Student/Courses/Show', [
              'course' => $course,
              'lessons' => $lessons,
              'progress' => $progress,
          ]);
        }
        else {
          return inertia('Student/Courses/Show', [
              'course' => $course,
              'lessons' => $lessons,
              'progress' => $progress,
          ]);
        }
    }

    public function markAsCompleted(Request $request, CourseLesson $lesson)
    {
        try {
            $user = $request->user();
            $now = now();

            // بررسی کاربر
            if (!$user || !$user->id) {
                \Log::error('User is not authenticated or invalid', ['user_id' => $user->id ?? 'null']);
                return inertia('Student/Courses/Show', [
                    'error' => 'کاربر احراز هویت نشده است',
                ])->with(['error' => 'کاربر احراز هویت نشده است']);
            }

            // بررسی وجود درس و دوره
            $course = $lesson->course;
            if (!$course || !$course->id) {
                \Log::error('Course is not valid or not associated with the lesson', ['course_id' => $course->id ?? 'null']);
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

            // بارگذاری دوره و درس‌ها
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

            // استفاده از رابطه courses برای ایجاد یا به‌روزرسانی رکورد
            $user->courses()->sync([
                $course->id => [
                    'enrolled_at' => $now,
                    'progress' => $courseProgress,
                    'last_accessed_at' => $now,
                    'completed_at' => $courseProgress >= 100 ? $now : null,
                    'is_favorite' => false,
                    'rating' => null,
                    'review' => null,
                    'payment_status' => 'pending',
                    'transaction_id' => null,
                    'expires_at' => null,
                ]
            ], false);

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

            if ($lastStudiedAt && $lastStudiedAt->isBefore($now->startOfDay())) {
                if ($lastStudiedAt->isYesterday()) {
                    $streak++;
                } else {
                    $streak = 1;
                }
            } elseif (!$lastStudiedAt) {
                $streak = 1;
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
                return back()->with([
                    'flash' => ['success' => 'درس با موفقیت به عنوان تکمیل شده علامت گذاری شد'],
                    'progress' => $courseProgress,
                    'dailyProgress' => $dailyProgress[$today] ?? 0,
                    'weeklyProgress' => $weeklyProgress[$weekStart] ?? 0,
                    'streak' => $streak,
                    'xp' => $studentProgress->xp,
                    'level' => $newLevel,
                    // اضافه کردن اطلاعات درس برای آپدیت
                    'lesson' => [
                        'id' => $lesson->id,
                        'is_completed' => true
                    ]
                ]);
            }

            // پاسخ به درخواست API
            return response()->json([
                'success' => true,
                'message' => 'درس با موفقیت تکمیل شد',
                'progress' => $courseProgress,
                'dailyProgress' => $dailyProgress,
                'weeklyProgress' => $weeklyProgress,
                'streak' => $streak,
                'xp' => $studentProgress->xp,
                'level' => $newLevel,
                'lesson' => [
                    'id' => $lesson->id,
                    'is_completed' => true
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in markAsCompleted: ' . $e->getMessage(), [
                'user_id' => $user->id ?? 'null',
                'course_id' => $course->id ?? 'null',
                'lesson_id' => $lesson->id ?? 'null',
            ]);
            if ($request->header('X-Inertia')) {
                return inertia('Student/Courses/Show', [
                    'course' => $lesson->course,
                    'lessons' => $lesson->course ? $lesson->course->course_lessons : [],
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

    private function determineStudentLevel(User $user): string
    {
        $progress = $user->studentProgress()->firstOrCreate();

        if ($progress->xp >= 500) return 'advanced';
        if ($progress->xp >= 200) return 'intermediate';
        return 'beginner';
    }

    private function determineCourseStatus(Course $course, User $user): string
    {
        $totalLessons = $course->course_lessons->count();
        $completedLessons = $course->course_lessons->filter(function ($lesson) use ($user) {
            return $lesson->users->contains($user->id) &&
                $lesson->users->find($user->id)->pivot->completed;
        })->count();

        $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

        if ($progress === 100) return 'completed';
        if ($progress > 0) return 'active';
        return 'paused';
    }

    private function determineEndDate(Course $course, User $user): ?Carbon
    {
        try {
            // اگر ستون completed_at وجود دارد
            if (Schema::hasColumn('course_lesson_user', 'completed_at')) {
                return $course->course_lessons()
                    ->whereHas('users', fn($q) => $q->where('user_id', $user->id)->where('completed', true))
                    ->orderByDesc('course_lesson_user.completed_at')
                    ->first()?->users->first()?->pivot?->completed_at;
            }

            // راه‌حل جایگزین با updated_at
            return $course->course_lessons()
                ->whereHas('users', fn($q) => $q->where('user_id', $user->id)->where('completed', true))
                ->orderByDesc('course_lesson_user.updated_at')
                ->first()?->users->first()?->pivot?->updated_at;

        } catch (\Exception $e) {
            Log::error('Error getting end date', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function destroy(Course $course)
    {
        auth()->user()->courses()->detach($course);

        return redirect()->route('student.courses.index')
            ->with('success', 'از دوره انصراف دادید.');
    }


}
