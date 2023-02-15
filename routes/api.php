<?php

use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("quiz")->group(function () {
    Route::get('{id}', [ QuizController::class, 'show' ]);
    Route::post('/publish', [ QuizController::class, 'publish' ]);
    Route::post('/draft', [ QuizController::class, 'draft' ]);
    Route::get('/draft', [ QuizController::class, 'draftQuestions' ]);
    Route::get('/publish', [ QuizController::class, 'publishedQuestions' ]);
});
