<?php

use App\Http\Controllers\GeneralController;
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

use App\Http\Controllers\WebSocketController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/online-users/{team}', [WebSocketController::class, 'getOnlineUsers']);
    Route::post('/set-online/{team}', [WebSocketController::class, 'setOnline']);
    Route::post('/mouse-position', [WebSocketController::class, 'sendMousePosition']);
    Route::post('/words/{word}/update', [WebSocketController::class, 'updateWord']);
    Route::get('/words/{word}/history', [WebSocketController::class, 'getHistory']);
});
