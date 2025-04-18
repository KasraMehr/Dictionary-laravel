<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseLessonController extends Controller
{
  public function index(Course $course)
  {
      $lessons = $course->course_lessons()
          ->orderBy('order')
          ->get();

      return Inertia::render('Teacher/CourseLessons/Index', [
          'course' => $course,
          'lessons' => $lessons,
      ]);
  }

    public function create(Course $course)
    {
        $quizzes = Quiz::all();

        return inertia('Teacher/CourseLessons/Create', [
            'course' => $course,
            'quizzes' => $quizzes,
            'skills' => CourseLesson::SKILLS
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'in:' . implode(',', array_keys(CourseLesson::SKILLS)),
            'content' => 'required|array',
            'quiz_id' => 'nullable|exists:quizzes,id'
        ]);

        $course->course_lessons()->create($validated);

        return redirect()->route('teacher.courses.show', $course)
            ->with('success', 'درس جدید با موفقیت ایجاد شد');
    }

    public function edit(Course $course, CourseLesson $lesson)
    {
        return inertia('Teacher/CourseLessons/Edit', [
            'course' => $course,
            'lesson' => $lesson,
            'skills' => CourseLesson::SKILLS
        ]);
    }

    public function update(Request $request, Course $course, CourseLesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'in:' . implode(',', array_keys(CourseLesson::SKILLS)),
            'content' => 'required|array',
            'quiz_id' => 'nullable|exists:quizzes,id'
        ]);

        $lesson->update($validated);

        return redirect()->route('teacher.courses.show', $course)
            ->with('success', 'درس با موفقیت به‌روزرسانی شد');
    }
}
