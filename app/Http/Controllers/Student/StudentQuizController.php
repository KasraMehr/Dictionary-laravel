<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Inertia\Inertia;
use Inertia\Response;

class StudentQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $quizzes = Quiz::where('status', 'active')->get()->map(function ($quiz) {
              return [
                  'id' => $quiz->id,
                  'title' => $quiz->title,
                  'description' => $quiz->description ?? '',
                  'level' => $quiz->level ?? 'نامشخص',
                  'time_limit' => $quiz->time_limit,
                  'pass_score' => $quiz->pass_score,
                  'status' => $quiz->status,
                  'type' => match ($quiz->type) {
                      'lesson' => 'course',
                      'final' => 'free',
                      'placement' => 'practice',
                      default => 'unknown'
                  },
              ];
          });

          return Inertia::render('Student/Quiz/Index', [
              'quizzes' => $quizzes,
          ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $quiz = Quiz::with('questions')->findOrFail($id);
      return inertia('Student/Quiz/Show', [
          'quiz' => $quiz,
      ]);
    }

    public function submit(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $answers = $request->input('answers');

        // محاسبه نمره
        $score = $this->calculateScore($quiz, $answers);

        // ذخیره نتیجه در جدول UserQuizAttempts
        $attempt = UserQuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quizId,
            'score' => $score,
            'passed' => $score >= $quiz->pass_score,
        ]);

        return inertia('Student/Quiz/Show', [
            'score' => $score,
            'passed' => $attempt->passed,
        ]);
    }

    // نمایش نتیجه آزمون
    public function result($quizId)
    {
        $user = auth()->user();
        $attempt = UserQuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quizId)
            ->latest()
            ->firstOrFail();

        return response()->json($attempt);
    }

    // محاسبه نمره کاربر
    private function calculateScore(Quiz $quiz, array $answers)
    {
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $correctAnswers++;
            }
        }

        return ($correctAnswers / $totalQuestions) * 100;
    }
}
