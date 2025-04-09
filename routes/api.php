<?php

use App\Http\Controllers\Api\WordImportController;
use App\Http\Controllers\General\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/import-word/{word}', [WordImportController::class, 'importWord']);
Route::get('/fetch-words', [GeneralController::class, 'fetchWords']);

Route::post('/set-locale', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'fa', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return response()->json(['message' => 'Language changed to ' . app()->getLocale()]);
});

