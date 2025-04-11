<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;

class QuizController extends Controller
{
      public function index()
      {
          $quizzes = Quiz::with('course')
              ->get();

          return inertia('Teacher/Quiz/Index', compact('quizzes'));
      }

      public function create()
      {
          $courses = Course::where('created_by', auth()->id())
              ->where('status', 'published')
              ->get();

          return inertia('Teacher/Quiz/Create', compact('courses'));
      }

      public function store(Request $request)
      {
          $validated = $request->validate([
              'title' => 'required|string|max:255',
              'type' => 'required|in:lesson,final,placement',
              'course_id' => 'nullable|exists:courses,id',
              'level' => 'nullable|string',
              'time_limit' => 'required|integer|min:0',
              'pass_score' => 'required|integer|min:0|max:100',
              'status' => 'required|in:active,inactive',
          ]);

          $validated['created_by'] = auth()->id();

          Quiz::create($validated);

          return redirect()->route('teacher.quizzes.index')
              ->with('success', 'آزمون با موفقیت ایجاد شد.');
      }

      public function edit(Quiz $quiz)
      {
          $courses = Course::where('created_by', auth()->id())
              ->where('status', 'published')
              ->get();

          return inertia('Teacher/Quiz/Edit', [
              'quiz' => $quiz,
              'courses' => $courses,
          ]);
      }

      public function update(Request $request, Quiz $quiz)
      {
          $validated = $request->validate([
              'title' => 'required|string|max:255',
              'type' => 'required|in:lesson,final,placement',
              'course_id' => 'nullable|exists:courses,id',
              'level' => 'nullable|string',
              'time_limit' => 'required|integer|min:0',
              'pass_score' => 'required|integer|min:0|max:100',
              'status' => 'required|in:active,inactive',
          ]);

          $quiz->update($validated);

          return redirect()->route('teacher.quizzes.index')
              ->with('success', 'آزمون با موفقیت به‌روزرسانی شد.');
      }

      public function destroy(Quiz $quiz)
      {
          $quiz->delete();

          return redirect()->route('teacher.quizzes.index')
              ->with('success', 'آزمون با موفقیت حذف شد.');
      }

      public function questionsIndex(Quiz $quiz)
      {
          $quiz->load('questions');

          return inertia('Teacher/Quiz/Question/Index', [
              'quiz' => $quiz,
          ]);
      }

      public function questionsCreate(Quiz $quiz)
      {
          return inertia('Teacher/Quiz/Question/Create', [
              'quiz' => $quiz,
          ]);
      }
}
