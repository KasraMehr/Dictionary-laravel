<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;

class CourseLessonController extends Controller
{
  public function index(Course $course)
  {
      $lessons = $course->course_lessons()->orderBy('order')->get();
      return view('teacher.lessons.index', compact('course', 'lessons'));
  }

  public function create(Course $course)
  {
      return view('teacher.lessons.create', compact('course'));
  }

  public function store(Request $request, Course $course)
  {
      $validated = $request->validate([
          'title' => 'required|string|max:255',
          'content' => 'nullable|string',
          'video_url' => 'nullable|url',
          'order' => 'nullable|integer',
          'quiz_id' => 'nullable|exists:quizzes,id',
      ]);

      $course->course_lessons()->create($validated);

      return redirect()->route('teacher.courses.lessons.index', $course->id)->with('success', 'درس جدید اضافه شد.');
  }

  public function edit(Course $course, CourseLesson $lesson)
  {
      return view('teacher.lessons.edit', compact('course', 'lesson'));
  }

  public function update(Request $request, Course $course, CourseLesson $lesson)
  {
      $validated = $request->validate([
          'title' => 'required|string|max:255',
          'content' => 'nullable|string',
          'video_url' => 'nullable|url',
          'order' => 'nullable|integer',
          'quiz_id' => 'nullable|exists:quizzes,id',
      ]);

      $lesson->update($validated);

      return redirect()->route('teacher.courses.lessons.index', $course->id)->with('success', 'درس بروزرسانی شد.');
  }

  public function destroy(Course $course, CourseLesson $lesson)
  {
      $lesson->delete();
      return redirect()->route('teacher.courses.lessons.index', $course->id)->with('success', 'درس حذف شد.');
  }
}
