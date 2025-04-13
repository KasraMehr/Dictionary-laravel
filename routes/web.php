<?php

use App\Http\Controllers\General\AchievementController;
use App\Http\Controllers\General\ContactController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\General\LearnController;
use App\Http\Controllers\General\ReportController;
use App\Http\Controllers\Teacher\CourseLessonController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Teacher\QuizController;
use App\Http\Controllers\Teacher\ResourceController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Translator\CategoryController;
use App\Http\Controllers\Translator\DashboardController;
use App\Http\Controllers\Translator\TeamController;
use App\Http\Controllers\Translator\WordController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Middleware\IsStudent;
use App\Http\Middleware\IsTeacher;
use App\Http\Middleware\IsTranslator;
use App\Http\Middleware\TeamMemberMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [GeneralController::class, 'landingData'])->name('landing');
Route::get('/reports', [ReportController::class, 'statisticReport'])->name('reports');
Route::get('/library', [GeneralController::class, 'index'])->name('library');
Route::get('/search', [GeneralController::class, 'search'])->name('search');
Route::get('/daily-test', [GeneralController::class, 'DailyTest'])->name('DailyTest');
Route::get('/daily-words', [GeneralController::class, 'DailyWords'])->name('DailyWords');

// Communicate routes
Route::get('/about-us', [GeneralController::class, 'aboutUs'])->name('aboutUs');
Route::get('/contact-us', [GeneralController::class, 'contactUs'])->name('contactUs');
Route::get('/FAQ', [GeneralController::class, 'FAQ'])->name('faq');

Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/learn', [LearnController::class, 'learn'])->name('learn');
Route::get('/topics', [LearnController::class, 'topics'])->name('topics');
Route::get('/levels', [LearnController::class, 'levels'])->name('levels');
Route::get('/grammars', [LearnController::class, 'grammars'])->name('grammars');
Route::get('/word/{native_lang}-{translated_lang}/{word}', [WordController::class, 'show'])->name('word.show');


Route::get('/csrf-token', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function ()
{
    Route::middleware([IsTranslator::class])->prefix('translator')->name('translator.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Words Management Routes
        Route::get('/words', [WordController::class, 'index'])->name('words.index');
        Route::post('/words', [WordController::class, 'store'])->name('words.store');
        Route::get('/words/{word}', [WordController::class, 'show'])->name('words.show'); // Show specific word
        Route::put('/words/{word}', [WordController::class, 'update'])->name('words.update'); // Update word
        Route::delete('/words/{word}', [WordController::class, 'destroy'])->name('words.destroy'); // Delete word

        // Category Management Routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/words', [CategoryController::class, 'getCategoryWords']); //get the words of a category
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); // Update category
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Delete category

        // Team Management Routes
        Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
        Route::post('/teams/{team}/join-request', [TeamController::class, 'sendJoinRequest'])->name('teams.join-request');
        Route::delete('/teams/{team}/leave-team', [TeamController::class, 'leave'])->name('teams.leave-team');

        Route::middleware([TeamMemberMiddleware::class])->prefix('team')->name('team.')->group(function () {
            Route::get('/{team}/words', [TeamController::class, 'team_words'])->name('words');
            Route::post('/{team}/words/add-word', [TeamController::class, 'addWordToTeam'])->name('addWord');
            Route::get('/{team}/categories', [TeamController::class, 'team_categories'])->name('categories');
            Route::post('/{team}/categories/add-category', [TeamController::class, 'addCategory'])->name('addCategory');
        });

        // Chart data
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    });

    Route::middleware([IsTeacher::class])->prefix('teacher')->name('teacher.')->group(function () {

        Route::get('/dashboard', [CourseController::class, 'dashboard'])->name('dashboard');

        Route::resource('courses', CourseController::class)
        ->names('courses');

        Route::prefix('courses/{course}')->group(function () {
            Route::get('/lessons/create', [CourseLessonController::class, 'create'])
                ->name('courses.lessons.create');

            Route::post('/lessons', [CourseLessonController::class, 'store'])
                ->name('courses.lessons.store');

            Route::get('/lessons/{lesson}/edit', [CourseLessonController::class, 'edit'])
                ->name('courses.lessons.edit');

            Route::put('/lessons/{lesson}', [CourseLessonController::class, 'update'])
                ->name('courses.lessons.update');

            Route::resource('quizzes', QuizController::class)
                ->names('courses.quizzes');
        });

        Route::resource('quizzes', QuizController::class)->names('quizzes');

        Route::prefix('quizzes/{quiz}/questions')->group(function () {
            Route::get('/', [QuizController::class, 'questionsIndex'])
                ->name('quizzes.questions.index');
            Route::get('/create', [QuizController::class, 'questionsCreate'])
                ->name('quizzes.questions.create');
        });

        Route::resource('questions', QuestionController::class)->except(['index', 'create'])->names('questions');

        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::post('/students/{student}/level', [StudentController::class, 'updateLevel'])->name('students.update-level');
        Route::post('/students/{student}/note', [StudentController::class, 'addNote'])->name('students.add-note');

        Route::resource('resources', ResourceController::class)->names('resources');

    });

    Route::middleware([IsStudent::class])->prefix('student')->name('student.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/courses', [WordController::class, 'index'])->name('words.index');
        Route::get('/courses/{id}', [WordController::class, 'show'])->name('words.show'); // Show specific word
        Route::post('/courses/{id}/enroll', [WordController::class, 'store'])->name('words.store');
        Route::get('/my-courses', [WordController::class, 'show'])->name('words.show'); // Show specific word

        // Lessons Management Routes
        Route::get('/courses/{course_id}/lessons', [WordController::class, 'index'])->name('words.index');
        Route::post('/lessons/{id}/mark-complete', [WordController::class, 'store'])->name('words.store');
        Route::get('/lessons/{id}', [WordController::class, 'show'])->name('words.show'); // Show specific word

        // Quiz Management Routes
        Route::get('/lessons/{id}/exercises', [WordController::class, 'index'])->name('words.index');
        Route::post('/exercises/{id}/submit', [WordController::class, 'store'])->name('words.store');
        Route::get('/quizzes/{lesson_id}', [WordController::class, 'show'])->name('words.show'); // Show specific word
        Route::post('//quizzes/{id}/submit', [WordController::class, 'store'])->name('words.store');
        Route::get('/results/quizzes', [WordController::class, 'show'])->name('words.show'); // Show specific word

        // Progress Management Routes
        Route::get('/progress', [WordController::class, 'index'])->name('words.index');
        Route::get('/progress/{course_id}', [WordController::class, 'index'])->name('words.index');
    });
});
