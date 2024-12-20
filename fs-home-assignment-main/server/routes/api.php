<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::post('signup', [RegisterController::class, 'signup']);
Route::post('login', [TokenController::class, 'login']);

if (Auth::check()) {
    Route::get('questions', [QuizController::class, 'questions']);
    Route::post('validate', [QuizController::class, 'submit']);
}
Route::middleware('auth:sanctum')->get('questions', [QuizController::class, 'questions']);
Route::middleware('auth:sanctum')->post('validate', [QuizController::class, 'submit']);
