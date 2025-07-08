<?php

// app/Http/Controllers/Student/CourseController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
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
                'course_user.progress as pivot_progress',
                'course_user.enrolled_at as pivot_enrolled_at',
                'course_user.updated_at as pivot_updated_at',
                'course_user.is_favorite as pivot_is_favorite',
            ])
            ->withCount('course_lessons')
            ->orderBy('courses.created_at', 'desc')
            ->paginate(12);

        $stats = [
            'total_courses' => $user->courses()->count(),
            'in_progress' => $user->courses()
                ->wherePivot('progress', '>', 0)
                ->wherePivot('progress', '<', 100)
                ->count(),
            'completed' => $user->courses()
                ->wherePivot('progress', '=', 100)
                ->count(),
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
            $user = $request->user();

            $user->lessons()->syncWithoutDetaching([
                $lesson->id => [
                    'completed' => true,
                    'completed_at' => now(),
                    'progress' => 100,
                    'started_at' => now(),
                ]
            ]);

            $course = $lesson->course;
            $totalLessons = $course->course_lessons->count();
            $completedLessons = $user->lessons()
                ->where('course_id', $course->id)
                ->where('completed', true)
                ->count();

            $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

            $user->courses()->updateExistingPivot($course->id, [
                'progress' => $courseProgress,
                'last_accessed_at' => now(),
                'completed_at' => $courseProgress >= 100 ? now() : null,
            ]);

            // برای درخواست‌های Inertia
            if ($request->header('X-Inertia')) {
                return redirect()->back()->with([
                    'success' => 'درس با موفقیت به عنوان تکمیل شده علامت گذاری شد',
                    'courseProgress' => $courseProgress,
                ]);
            }

            // برای درخواست‌های API معمولی
            return response()->json([
                'success' => true,
                'message' => 'درس با موفقیت به عنوان تکمیل شده علامت گذاری شد',
                'course_progress' => $courseProgress,
            ]);
        }

    public function destroy(Course $course)
    {
        auth()->user()->courses()->detach($course);

        return redirect()->route('student.courses.index')
            ->with('success', 'از دوره انصراف دادید.');
    }
}
