<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
  public function store(Request $request)
      {
          $validated = $request->validate([
              'question_text' => 'required|string',
              'question_type' => 'required|in:mcq,fill_blank,match,text',
              'options' => 'required_if:question_type,mcq|array',
              'correct_answer' => 'required|string',
              'points' => 'required|integer|min:1',
              'quiz_id' => 'required|exists:quizzes,id',
          ]);

          // برای سوالات MCQ، correct_answer باید اندیس گزینه صحیح باشد
          if ($validated['question_type'] === 'mcq') {
              $validated['options'] = array_values($validated['options']);
          }

          Question::create($validated);

          return redirect()->route('teacher.quizzes.questions.index', $validated['quiz_id'])
              ->with('success', 'سوال با موفقیت ایجاد شد.');
      }

      public function edit(Question $question)
      {
          return inertia('Teacher/Quiz/Question/Edit', [
              'question' => $question,
              'quiz' => $question->quiz,
          ]);
      }

      public function update(Request $request, Question $question)
      {
          $validated = $request->validate([
              'question_text' => 'required|string',
              'question_type' => 'required|in:mcq,fill_blank,match,text',
              'options' => 'required_if:question_type,mcq|array',
              'correct_answer' => 'required|string',
              'points' => 'required|integer|min:1',
          ]);

          $question->update($validated);

          return redirect()->route('teacher.quizzes.questions.index', $question->quiz_id)
              ->with('success', 'سوال با موفقیت به‌روزرسانی شد.');
      }

      public function destroy(Question $question)
      {
          $quiz_id = $question->quiz_id;
          $question->delete();

          return redirect()->route('teacher.quizzes.questions.index', $quiz_id)
              ->with('success', 'سوال با موفقیت حذف شد.');
      }
}
