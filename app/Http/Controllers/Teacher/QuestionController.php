<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Quiz $quiz)
     {
         $questions = $quiz->questions()->paginate(10);
         return view('teacher.questions.index', compact('quiz', 'questions'));
     }

     public function create(Quiz $quiz)
     {
         return view('teacher.questions.create', compact('quiz'));
     }

     public function store(Request $request, Quiz $quiz)
     {
         $validated = $request->validate([
             'question_text' => 'required|string',
             'question_type' => 'required|in:mcq,fill_blank,match,text',
             'options' => 'nullable|array',
             'correct_answer' => 'required|array',
             'points' => 'required|integer|min:1',
         ]);

         $validated['quiz_id'] = $quiz->id;

         Question::create($validated);

         return redirect()->route('teacher.quizzes.questions.index', $quiz)->with('success', 'سوال با موفقیت ثبت شد.');
     }

     public function edit(Quiz $quiz, Question $question)
     {
         return view('teacher.questions.edit', compact('quiz', 'question'));
     }

     public function update(Request $request, Quiz $quiz, Question $question)
     {
         $validated = $request->validate([
             'question_text' => 'required|string',
             'question_type' => 'required|in:mcq,fill_blank,match,text',
             'options' => 'nullable|array',
             'correct_answer' => 'required|array',
             'points' => 'required|integer|min:1',
         ]);

         $question->update($validated);

         return redirect()->route('teacher.quizzes.questions.index', $quiz)->with('success', 'سوال بروزرسانی شد.');
     }

     public function destroy(Quiz $quiz, Question $question)
     {
         $question->delete();
         return back()->with('success', 'سوال حذف شد.');
     }
}
