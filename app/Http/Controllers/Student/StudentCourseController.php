<?php

// app/Http/Controllers/Student/CourseController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Course::all();
        // Apply filters
        if ($request->status === 'in-progress') {
            $query->wherePivot('progress', '>', 0)
                ->wherePivot('progress', '<', 100);
        } elseif ($request->status === 'completed') {
            $query->wherePivot('progress', '=', 100);
        } elseif ($request->status === 'not-started') {
            $query->wherePivot('progress', '=', 0);
        }

        // Apply sorting
//        if ($request->sort === 'oldest') {
//            $query->orderBy('user_course.created_at');
//        } elseif ($request->sort === 'progress') {
//            $query->orderBy('user_course.progress', 'desc');
//        } else {
//            $query->orderBy('user_course.created_at', 'desc');
//        }

//        $courses = $query->paginate(12);

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

        return inertia('Student/Courses/Index', compact('query', 'stats'));
    }

    public function show(Course $course)
    {
        // $course->load(['category', 'teacher', 'lessons'])
        //     ->loadCount('lessons');

        return inertia('Student/Courses/Show', [
            // 'course' => $course,
            // 'progress' => auth()->user()
            //     ->courses()
            //     ->where('course_id', $course->id)
            //     ->first()
            //     ->pivot
            //     ->progress
        ]);
    }

    public function destroy(Course $course)
    {
        auth()->user()->courses()->detach($course);

        return redirect()->route('student.courses.index')
            ->with('success', 'از دوره انصراف دادید.');
    }
}
