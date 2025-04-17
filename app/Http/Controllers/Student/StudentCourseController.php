<?php

// app/Http/Controllers/Student/CourseController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;

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
      // بارگذاری درس‌های دوره
      $course->load('course_lessons');

      // محاسبه پیشرفت کلی دوره
      // $completedLessons = $course->course_lessons->filter(function($lesson) {
      //     return $lesson->pivot->completed;
      // });

      // $progress = $course->course_lessons->isEmpty() ? 0 : round(($completedLessons->count() / $course->course_lessons->count()) * 100);

      // ارسال داده‌ها به نمای Inertia
      return inertia('Student/Courses/Show', [
          'course' => $course,
          'lessons' => $course->course_lessons,
          // 'progress' => $progress
      ]);
    }

    public function destroy(Course $course)
    {
        auth()->user()->courses()->detach($course);

        return redirect()->route('student.courses.index')
            ->with('success', 'از دوره انصراف دادید.');
    }
}
