<?php

use App\Http\Controllers\AchievementController;
use App\Http\Middleware\TeamMemberMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LearnController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;


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
Route::get('/word/{native_lang}-{translated_lang}/{id}', [WordController::class, 'show'])->name('word.show');


Route::get('/csrf-token', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function ()
{
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

    Route::middleware([TeamMemberMiddleware::class])->group(function () {
        Route::get('/team/{team}/words', [TeamController::class, 'team_words'])->name('team.words');
        Route::post('/team/{team}/words/add-word', [TeamController::class, 'addWordToTeam'])->name('team.addWord');
        Route::get('/team/{team}/categories', [TeamController::class, 'team_categories'])->name('team.categories');
        Route::post('/team/{team}/categories/add-category', [TeamController::class, 'addCategory'])->name('team.addCategory');
    });

    // Chart data
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

});
