<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Course $course)
     {
         $quizzes = $course->quizzes()->latest()->get();
         return view('teacher.quizzes.index', compact('course', 'quizzes'));
     }

     public function create(Course $course)
     {
         return view('teacher.quizzes.create', compact('course'));
     }

     public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:lesson,final,placement',
            'course_id' => 'nullable|exists:courses,id',
            'level' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:0',
            'pass_score' => 'required|integer|min:0|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Quiz::create($validated);

        return redirect()->route('teacher.quizzes.index')->with('success', 'آزمون با موفقیت ساخته شد.');
    }

    public function edit(Quiz $quiz)
    {
        $courses = Course::all();
        return view('teacher.quizzes.edit', compact('quiz', 'courses'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:lesson,final,placement',
            'course_id' => 'nullable|exists:courses,id',
            'level' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:0',
            'pass_score' => 'required|integer|min:0|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $quiz->update($validated);

        return redirect()->route('teacher.quizzes.index')->with('success', 'آزمون بروزرسانی شد.');
    }
     public function destroy(Course $course, Quiz $quiz)
     {
         $quiz->delete();
         return redirect()->route('teacher.courses.quizzes.index', $course->id)->with('success', 'آزمون حذف شد.');
     }
}
