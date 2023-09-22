<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ParticipateController;

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

Route::controller(UserController::class)->group(function ($router) {
    Route::post('v1/login', 'login');
    Route::post('v1/signup', 'register');
    Route::get('v1/logout', 'logout');
    Route::put('v1/profile', 'editprofile');
    Route::get('v1/profile', 'getprofile');
});

Route::controller(QuestionController::class)->group(function ($router) {
    Route::post('v1/question', 'addQuestion');
    Route::get('v1/question', 'getQuestion');
    Route::get('v1/userquestion', 'getUserQuestion');
});

Route::controller(PollController::class)->group(function ($router) {
    Route::post('v1/poll', 'postPoll');
    Route::get('v1/poll', 'getPoll');
    Route::get('v1/userpoll', 'getUserPoll');
});

Route::controller(ParticipateController::class)->group(function ($router) {
    Route::post('v1/participate', 'postParticipate');
    Route::get('v1/participate', 'getParticipate');
});
